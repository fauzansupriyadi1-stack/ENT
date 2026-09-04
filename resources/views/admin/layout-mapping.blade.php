@extends('layouts.admin')

@section('title', 'Layout Mapping Hero')
@section('page_title', 'Layout Mapping Hero (Slot 1 s/d Slot 7)')
@section('page_subtitle', 'Visualisasi otomatis penempatan artikel berita pada slot FOTO 1 - FOTO 7 di landing page')

@section('content')

<section class="admin-layout-preview">
    <div class="section-header">
        <h2>⚡ Mapping Otomatis Layout Hero (Slot 1 s/d Slot 7)</h2>
        <p>Setiap berita yang Anda upload dari halaman <strong>Post Berita</strong> akan <strong>otomatis mengisi slot FOTO 1 s/d FOTO 7</strong> berdasarkan urutan posting terbaru</p>
    </div>

    <div class="mapping-grid">
        @foreach ($heroSlots as $index => $slot)
            @php
                $article = $slot->article ?? ($newsList->get($index) ?? null);
            @endphp
            <div class="mapping-card">
                <div class="mapping-card__badge">
                    <span>SLOT #{{ $index + 1 }}</span>
                    <strong>{{ str_replace('_', ' ', $slot->slot_code) }}</strong>
                </div>
                <div class="mapping-card__content">
                    <span class="badge-cat">{{ $article && $article->category ? $article->category->name : 'General' }}</span>
                    <h4>{{ $slot->override_title ?? ($article ? $article->title : 'Belum Ada Berita') }}</h4>
                    <small>⏱️ {{ $article && $article->created_at ? $article->created_at->format('d M Y H:i') : '-' }} | 👤 {{ $article && $article->user ? $article->user->name : 'Admin' }}</small>
                </div>
                <div class="mapping-card__status">
                    <span class="status-dot"></span> {{ $slot->is_manual ? 'Manual Overridden' : 'Otomatis Terhubung ke MySQL' }}
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
