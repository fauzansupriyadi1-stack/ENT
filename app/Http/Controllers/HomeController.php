<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\HeroSlot;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the FZN NEWS landing page with dynamic MySQL data.
     */
    public function index(Request $request, $category = null)
    {
        // 1. Categories
        $categories = Category::where('is_active', true)->get();
        $selectedCategory = $category ?: $request->query('category');

        // 2. News Bar Items — all latest published articles, breaking news sorted first
        $breakingNewsQuery = Article::with('category')
            ->where('status', 'published');

        if ($selectedCategory) {
            $breakingNewsQuery->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory)->orWhere('name', $selectedCategory);
            });
        }

        $breakingNews = $breakingNewsQuery
            ->orderByDesc('is_breaking')
            ->latest('published_at')
            ->take(12)
            ->get();

        // 3. Dynamic Hero Articles (FOTO 1 - FOTO 8 mapping)
        $heroSlots = HeroSlot::with('article.category', 'article.user')->get()->keyBy('slot_code');

        $latestArticlesQuery = Article::with('category', 'user')
            ->where('status', 'published');

        if ($selectedCategory) {
            $latestArticlesQuery->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory)->orWhere('name', $selectedCategory);
            });
        }

        // Hero always uses the latest 8 articles (FOTO 1 to FOTO 8)
        $latestArticles = $latestArticlesQuery->latest('published_at')->take(8)->get();

        // Build hero articles
        $heroArticles = [];

        if ($selectedCategory) {
            // Jika memilih kategori spesifik, tampilkan artikel kategori tersebut secara berurutan sampai 8
            foreach ($latestArticles->take(8) as $index => $articleObj) {
                $slotIndex = $index + 1;
                $heroArticles[$slotIndex] = [
                    'slot'        => "FOTO {$slotIndex}",
                    'title'       => $articleObj->title,
                    'slug'        => $articleObj->slug,
                    'category'    => $articleObj->category ? $articleObj->category->name : '',
                    'author'      => $articleObj->user ? $articleObj->user->name : '',
                    'author_bio'  => $articleObj->user ? $articleObj->user->bio : '',
                    'image'       => $articleObj->image,
                    'published_at'=> $articleObj->published_at,
                    'excerpt'     => $articleObj->excerpt ?? '',
                    'content'     => $articleObj->content ?? '',
                ];
            }
        } else {
            // Jika memilih "Semua", prioritaskan artikel terbaru (latest published). Gunakan manual pin jika slot is_manual == true
            for ($i = 1; $i <= 8; $i++) {
                $slotKey = "FOTO_{$i}";
                $slotObj = $heroSlots->get($slotKey);

                $articleObj = ($slotObj && $slotObj->is_manual && $slotObj->article) ? $slotObj->article : ($latestArticles->get($i - 1) ?? null);

                if ($articleObj) {
                    $heroArticles[$i] = [
                        'slot'        => "FOTO {$i}",
                        'title'       => ($slotObj && $slotObj->is_manual && $slotObj->override_title) ? $slotObj->override_title : $articleObj->title,
                        'slug'        => $articleObj->slug,
                        'category'    => $articleObj->category ? $articleObj->category->name : '',
                        'author'      => $articleObj->user ? $articleObj->user->name : '',
                        'author_bio'  => $articleObj->user ? $articleObj->user->bio : '',
                        'image'       => $articleObj->image,
                        'published_at'=> $articleObj->published_at,
                        'excerpt'     => $articleObj->excerpt ?? '',
                        'content'     => $articleObj->content ?? '',
                    ];
                }
            }
        }

        // 4. More News Section — paginated separately (5 articles per page)
        $moreNewsQuery = Article::with('category', 'user')
            ->where('status', 'published');

        if ($selectedCategory) {
            $moreNewsQuery->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory)->orWhere('name', $selectedCategory);
            });
        }

        // Skip first 8 (used in hero) by offsetting with page logic
        $heroIds = $latestArticles->pluck('id');
        if ($heroIds->isNotEmpty()) {
            $moreNewsQuery->whereNotIn('id', $heroIds);
        }

        // 5 items per page: 1 tall card + 4 grid cards
        $moreNewsPaginator = $moreNewsQuery
            ->latest('published_at')
            ->paginate(5, ['*'], 'more_page')
            ->withQueryString();

        $moreNewsItems = $moreNewsPaginator->items();

        if (!empty($moreNewsItems)) {
            $firstArt = $moreNewsItems[0];
            $moreNewsTall = [
                'slot'        => 'TALL',
                'title'       => $firstArt->title,
                'slug'        => $firstArt->slug,
                'excerpt'     => $firstArt->excerpt ?? '',
                'category'    => $firstArt->category ? $firstArt->category->name : '',
                'published_at'=> $firstArt->published_at,
                'image'       => $firstArt->image,
                'author'      => $firstArt->user ? $firstArt->user->name : '',
            ];

            $moreNewsGrid = [];
            for ($j = 1; $j <= 4; $j++) {
                $art = $moreNewsItems[$j] ?? null;
                if ($art) {
                    $moreNewsGrid[] = [
                        'slot'        => 'GRID ' . $j,
                        'date'        => $art->published_at ? $art->published_at->format('d M Y') : '',
                        'published_at'=> $art->published_at,
                        'title'       => $art->title,
                        'slug'        => $art->slug,
                        'excerpt'     => $art->excerpt ?? '',
                        'category'    => $art->category ? $art->category->name : '',
                        'image'       => $art->image,
                        'author'      => $art->user ? $art->user->name : '',
                    ];
                }
            }
        } else {
            $moreNewsTall  = [];
            $moreNewsGrid  = [];
        }

        return view('home', compact(
            'categories', 'breakingNews', 'heroArticles',
            'moreNewsTall', 'moreNewsGrid', 'moreNewsPaginator',
            'selectedCategory'
        ));
    }

    /**
     * Display the full details page for a specific article.
     */
    public function show($slug)
    {
        $categories = Category::where('is_active', true)->get();

        $article = Article::with('category', 'user')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $article->increment('views_count');

        // Fetch related articles (same category or latest)
        $relatedArticles = Article::with('category', 'user')
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news-detail', compact('article', 'relatedArticles', 'categories'));
    }
}
