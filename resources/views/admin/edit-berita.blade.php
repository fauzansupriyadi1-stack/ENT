@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita')
@section('page_subtitle', 'Perbarui data artikel berita yang sudah ada di portal FZN NEWS')

@section('content')

<section class="admin-post-form">
    <div class="section-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <div>
            <h2>✏️ Edit Berita</h2>
            <p>Ubah detail artikel: judul, kategori, gambar, dan konten</p>
        </div>
        <a href="{{ route('admin.kelola-berita') }}" style="font-size:0.85rem; color:#64748b; text-decoration:none;">← Kembali ke Kelola Berita</a>
    </div>

    @if ($errors->any())
        <div style="background:#fee2e2; border:1px solid #f87171; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.85rem;">
            <ul style="margin-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="news-form" action="{{ route('admin.kelola-berita.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-grid">

            {{-- Judul --}}
            <div class="form-group form-group--full">
                <label for="news_title">Judul Berita Utama</label>
                <input type="text" id="news_title" name="title"
                       value="{{ old('title', $article->title) }}"
                       placeholder="Masukkan judul berita utama..." required>
            </div>

            {{-- Kategori --}}
            <div class="form-group">
                <label for="news_category">Kategori Berita</label>
                <select id="news_category" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="news_status">Status Rilis</label>
                <select id="news_status" name="status" required>
                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                    <option value="draft"     {{ old('status', $article->status) === 'draft'     ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                    <option value="archived"  {{ old('status', $article->status) === 'archived'  ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            {{-- Foto --}}
            <div class="form-group">
                <label for="news_image">Ganti Foto / Gambar Utama</label>

                @if($article->image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $article->image) }}"
                             alt="Foto saat ini"
                             style="width:120px; height:80px; object-fit:cover; border-radius:8px; border:2px solid #e2e8f0;">
                        <p style="font-size:0.72rem; color:#64748b; margin-top:4px;">Foto saat ini — kosongkan input di bawah untuk mempertahankan foto ini</p>
                    </div>
                @endif

                <input type="file" id="news_image" name="image" accept="image/*">
            </div>

            {{-- Breaking News Checkbox --}}
            <div class="form-group" style="flex-direction:row; align-items:center; gap:8px; margin-top:28px;">
                <input type="checkbox" id="is_breaking" name="is_breaking" value="1"
                       style="width:auto;" {{ $article->is_breaking ? 'checked' : '' }}>
                <label for="is_breaking" style="cursor:pointer; margin-bottom:0;">
                    Tandai Sebagai <strong>Breaking News Bar</strong>
                </label>
            </div>

            {{-- Excerpt --}}
            <div class="form-group form-group--full">
                <label for="news_excerpt">Ringkasan / Excerpt</label>
                <textarea id="news_excerpt" name="excerpt" rows="2"
                          placeholder="Ringkasan singkat berita...">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            {{-- Konten --}}
            <div class="form-group form-group--full">
                <label for="news_content">Isi Berita Lengkap</label>
                <textarea id="news_content" name="content" rows="8"
                          placeholder="Tulis isi berita lengkap di sini..." required>{{ old('content', $article->content) }}</textarea>
            </div>
        </div>

        <div class="form-actions" style="display:flex; gap:12px; align-items:center;">
            <button type="submit" class="btn-primary btn-submit">💾 Simpan Perubahan</button>
            <a href="{{ route('admin.kelola-berita') }}"
               style="padding:12px 20px; background:#f1f5f9; color:#475569; border-radius:8px; font-size:0.85rem; font-weight:600; text-decoration:none; border:1px solid #e2e8f0;">
               Batal
            </a>
        </div>
    </form>
</section>

@endsection
