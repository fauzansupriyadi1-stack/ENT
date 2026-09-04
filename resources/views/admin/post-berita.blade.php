@extends('layouts.admin')

@section('title', 'Post Berita Baru')
@section('page_title', 'Post Berita Baru')
@section('page_subtitle', 'Upload artikel berita baru — gambar & judul otomatis mengisi slot layout landing page (FOTO 1, 2, 3, dst.)')

@section('content')

<section class="admin-post-form">
    <div class="section-header">
        <h2>📝 Form Input Berita Baru</h2>
        <p>Isi formulir berikut untuk mempublikasikan artikel berita baru di portal FZN NEWS</p>
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

    <form class="news-form" action="{{ route('admin.post-berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div class="form-group form-group--full">
                <label for="news_title">Judul Berita Utama</label>
                <input type="text" id="news_title" name="title" value="{{ old('title') }}" placeholder="Masukkan judul berita utama..." required>
            </div>

            <div class="form-group">
                <label for="news_category">Kategori Berita</label>
                <select id="news_category" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="news_status">Status Rilis</label>
                <select id="news_status" name="status" required>
                    <option value="published">Direct Publish (Terbitkan Langsung)</option>
                    <option value="draft">Draft (Simpan Sementara)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="news_image">Upload Gambar / Foto Utama</label>
                <input type="file" id="news_image" name="image" accept="image/*">
            </div>

            <div class="form-group" style="flex-direction:row; align-items:center; gap:8px; margin-top:28px;">
                <input type="checkbox" id="is_breaking" name="is_breaking" value="1" style="width:auto;">
                <label for="is_breaking" style="cursor:pointer; margin-bottom:0;">Tandai Sebagai <strong>Breaking News Bar</strong></label>
            </div>

            <div class="form-group form-group--full">
                <label for="news_content">Ringkasan / Isi Berita</label>
                <textarea id="news_content" name="content" rows="6" placeholder="Tulis artikel atau ringkasan berita di sini..." required>{{ old('content') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary btn-submit">🚀 Publish Berita (Masuk Layout Otomatis)</button>
        </div>
    </form>
</section>

@endsection
