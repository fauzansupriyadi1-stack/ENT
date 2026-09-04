@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page_title', 'Kelola Semua Berita')
@section('page_subtitle', 'Manajemen artikel berita yang dipublish, diedit, atau dihapus dari portal FZN NEWS')

@section('content')

<section class="admin-news-table">
    <div class="section-header" style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2>Daftar Semua Berita Dipublish</h2>
            <p>Semua artikel berita yang aktif dan otomatis terisi pada layout website</p>
        </div>
        <a href="{{ route('admin.post-berita') }}" class="btn-primary">+ Post Berita Baru</a>
    </div>

    <div style="margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <form action="{{ route('admin.kelola-berita') }}" method="GET" style="display:flex; gap:10px; align-items:center;">
            <label for="category_id" style="font-weight:600; font-size:0.9rem;">Filter Berdasarkan Kategori:</label>
            <select name="category_id" id="category_id" class="form-control" style="max-width:300px; padding:8px; border-radius:5px; border:1px solid #ccc;" onchange="this.form.submit()">
                <option value="">-- Semua Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @if($selectedCategory)
                <a href="{{ route('admin.kelola-berita') }}" style="font-size: 0.85rem; color: #ef4444; text-decoration: none;">Reset Filter</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div style="background:#d1fae5; border:1px solid #10b981; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:700; font-size:0.85rem;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Dibaca</th>
                    <th>Tanggal Posting</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $news)
                    <tr>
                        <td>{{ $articles->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $news->title }}</strong> @if($news->is_breaking) <span style="background:#ef4444; color:#fff; font-size:0.6rem; padding:2px 6px; border-radius:3px;">BREAKING</span> @endif</td>
                        <td><span class="badge-cat">{{ $news->category ? $news->category->name : '-' }}</span></td>
                        <td>{{ $news->user ? $news->user->name : 'Admin' }}</td>
                        <td>
                            <span class="badge-status badge-status--{{ strtolower($news->status) }}">
                                {{ ucfirst($news->status) }}
                            </span>
                        </td>
                        <td>{{ number_format($news->views_count, 0, ',', '.') }}x</td>
                        <td>{{ $news->created_at ? $news->created_at->format('d M Y H:i') : '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.kelola-berita.edit', $news->id) }}" class="btn-action btn-edit" style="text-decoration:none;">Edit</a>
                                <form action="{{ route('admin.kelola-berita.delete', $news->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION LINK --}}
    <div style="margin-top:20px;">
        {{ $articles->links() }}
    </div>
</section>

@endsection
