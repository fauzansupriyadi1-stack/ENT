<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\HeroSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * 1. Dashboard Overview & Analytics (/admin)
     */
    public function index()
    {
        $todayCount = Article::whereDate('created_at', now()->today())->count();
        $monthCount = Article::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $yearCount  = Article::whereYear('created_at', now()->year)->count();

        $stats = [
            'today' => $todayCount,
            'this_month' => $monthCount,
            'this_year' => $yearCount,
        ];

        // Monthly chart data from DB
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyCounts = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyCounts[] = Article::whereMonth('created_at', $m)->whereYear('created_at', now()->year)->count();
        }

        $chartMonthly = [
            'labels' => $months,
            'data' => $monthlyCounts
        ];

        // Daily chart data for current week (Senin - Minggu)
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $dailyCounts = [];
        for ($d = 0; $d < 7; $d++) {
            $date = now()->startOfWeek()->addDays($d);
            $dailyCounts[] = Article::whereDate('created_at', $date->toDateString())->count();
        }

        $chartDaily = [
            'labels' => $days,
            'data' => $dailyCounts
        ];

        // Category distribution chart data
        $categories = Category::withCount('articles')->get();
        $catLabels = [];
        $catData = [];
        foreach ($categories as $cat) {
            $catLabels[] = $cat->name;
            $catData[] = $cat->articles_count;
        }

        $chartCategory = [
            'labels' => $catLabels,
            'data' => $catData
        ];

        // Yearly chart data for last 5 years
        $currentYear = now()->year;
        $yearlyLabels = [];
        $yearlyCounts = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = $currentYear - $i;
            $yearlyLabels[] = (string)$year;
            $yearlyCounts[] = Article::whereYear('created_at', $year)->count();
        }

        $chartYearly = [
            'labels' => $yearlyLabels,
            'data' => $yearlyCounts
        ];

        // Recent articles list
        $recentArticles = Article::with('category', 'user')->latest()->take(5)->get();

        // Hero Slots filled summary count
        $filledSlotsCount = HeroSlot::whereNotNull('article_id')->count();

        return view('admin.dashboard', compact('stats', 'chartMonthly', 'chartDaily', 'chartCategory', 'chartYearly', 'recentArticles', 'categories', 'filledSlotsCount'));
    }

    /**
     * 2. Post Berita Form Page (/admin/post-berita)
     */
    public function createPost()
    {
        $categories = Category::all();
        return view('admin.post-berita', compact('categories'));
    }

    /**
     * Store new article to MySQL (/admin/post-berita)
     */
    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $user = auth()->user();

        $article = Article::create([
            'category_id' => $request->category_id,
            'user_id' => $user->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'excerpt' => $request->excerpt ?: Str::limit(strip_tags($request->content), 150),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status,
            'is_breaking' => $request->has('is_breaking') ? true : false,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        // Auto-assign to latest available hero slot
        $unassignedSlot = HeroSlot::whereNull('article_id')->first();
        if ($unassignedSlot) {
            $unassignedSlot->update(['article_id' => $article->id]);
        }

        return redirect()->route('admin.kelola-berita')->with('success', 'Berita berhasil dipublikasikan!');
    }

    /**
     * 3. Layout Mapping Preview Page (/admin/layout-mapping)
     */
    public function layoutMapping()
    {
        $heroSlots = HeroSlot::with('article.category', 'article.user')->get();
        $newsList = Article::with('category', 'user')->latest()->take(8)->get();
        return view('admin.layout-mapping', compact('heroSlots', 'newsList'));
    }

    /**
     * 4. Kelola Berita Table Page (/admin/kelola-berita)
     */
    public function manageNews(Request $request)
    {
        $query = Article::with('category', 'user')->latest();
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $articles = $query->paginate(10)->appends($request->all());
        $categories = Category::all();
        $selectedCategory = $request->category_id;

        return view('admin.kelola-berita', compact('articles', 'categories', 'selectedCategory'));
    }

    /**
     * Delete article
     */
    public function deleteNews($id)
    {
        $article = Article::findOrFail($id);

        // Remove from hero slots if assigned
        HeroSlot::where('article_id', $article->id)->update(['article_id' => null]);

        $article->delete();

        return redirect()->route('admin.kelola-berita')->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Show Edit Berita Form (/admin/kelola-berita/{id}/edit)
     */
    public function editNews($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-berita', compact('article', 'categories'));
    }

    /**
     * Update article in MySQL (/admin/kelola-berita/{id})
     */
    public function updateNews(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt'     => 'nullable|string',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imagePath = $article->image; // keep old image by default

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($article->image && \Storage::disk('public')->exists($article->image)) {
                \Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . $article->id,
            'excerpt'     => $request->excerpt ?: Str::limit(strip_tags($request->content), 150),
            'content'     => $request->content,
            'image'       => $imagePath,
            'status'      => $request->status,
            'is_breaking' => $request->has('is_breaking') ? true : false,
            'published_at'=> $request->status === 'published' && !$article->published_at ? now() : $article->published_at,
        ]);

        return redirect()->route('admin.kelola-berita')->with('success', 'Berita berhasil diperbarui!');
    }
}
