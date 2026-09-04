@extends('layouts.app')

@section('title', $article->title . ' - FZN NEWS')

@push('styles')
<style>
    /* ── ARTICLE DETAIL PAGE ── */
    .article-page {
        background: #f8fafc;
        min-height: 100vh;
    }

    /* Hero Banner */
    .article-hero {
        position: relative;
        width: 100%;
        height: 480px;
        overflow: hidden;
        background: #1c4424;
    }

    .article-hero__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        opacity: 0.65;
    }

    .article-hero__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 30%, rgba(10,20,12,0.85) 100%);
    }

    .article-hero__content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 40px;
        max-width: 900px;
        margin: 0 auto;
    }

    .article-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--color-red);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 3px;
        letter-spacing: 1px;
        margin-bottom: 12px;
        animation: pulseRed 2s infinite;
    }

    .article-hero__category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(28, 68, 36, 0.9);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 3px;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        margin-left: 6px;
    }

    .article-hero__title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 900;
        color: #ffffff;
        line-height: 1.3;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }

    /* No hero image fallback */
    .article-no-hero {
        background: linear-gradient(135deg, #1c4424 0%, #2e6b3c 100%);
        height: 200px;
        display: flex;
        align-items: flex-end;
        padding: 32px 40px;
    }

    /* Article Body */
    .article-body-wrap {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 24px 80px;
    }

    .article-meta-bar {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        padding: 20px 0;
        border-bottom: 1.5px solid #e2e8f0;
        font-size: 0.82rem;
        color: #64748b;
    }

    .article-meta-bar a {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--color-primary);
        font-weight: 700;
        font-size: 0.82rem;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .article-meta-bar a:hover {
        opacity: 0.75;
    }

    .article-meta-sep {
        color: #cbd5e1;
    }

    /* Main title below hero (if no image) */
    .article-title-below {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 900;
        color: #111111;
        line-height: 1.3;
        margin: 28px 0 20px;
    }

    /* Excerpt Blockquote */
    .article-excerpt {
        background: #f0fdf4;
        border-left: 4px solid var(--color-primary);
        padding: 18px 24px;
        font-size: 1.05rem;
        font-style: italic;
        color: #334155;
        margin: 28px 0;
        border-radius: 0 10px 10px 0;
        line-height: 1.7;
    }

    /* Article content */
    .article-content {
        font-size: 1.07rem;
        line-height: 1.9;
        color: #1e293b;
        margin-bottom: 60px;
        text-align: justify;
    }

    .article-content p {
        margin-bottom: 1.4em;
    }

    /* Tags / Views strip */
    .article-footer-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 0;
        border-top: 1.5px solid #e2e8f0;
        border-bottom: 1.5px solid #e2e8f0;
        margin-bottom: 56px;
    }

    .article-views {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        color: #64748b;
    }

    .article-share-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Related Articles */
    .related-section {
        margin-top: 0;
    }

    .related-heading {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 900;
        color: #111111;
        margin-bottom: 6px;
    }

    .related-heading-line {
        width: 56px;
        height: 3px;
        background: var(--color-primary);
        border-radius: 2px;
        margin-bottom: 28px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .related-grid { grid-template-columns: 1fr; }
        .article-hero { height: 300px; }
        .article-hero__content { padding: 24px; }
        .article-hero__title { font-size: 1.4rem; }
        .article-title-below { font-size: 1.5rem; }
        .article-content { font-size: 1rem; }
    }

    .related-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.10);
    }

    .related-card__img {
        height: 150px;
        background: #f1f5f9;
        position: relative;
        overflow: hidden;
    }

    .related-card__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .related-card:hover .related-card__img img {
        transform: scale(1.05);
    }

    .related-card__placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-weight: 900;
        font-size: 1.1rem;
        color: #94a3b8;
        letter-spacing: 2px;
    }

    .related-card__body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .related-card__cat {
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--color-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .related-card__title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #111111;
        line-height: 1.45;
        margin-bottom: 10px;
    }

    .related-card__time {
        font-size: 0.72rem;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')
<div class="article-page">

    {{-- ── HERO IMAGE ── --}}
    @if($article->image)
    <div class="article-hero">
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-hero__img">
        <div class="article-hero__overlay"></div>
        <div class="article-hero__content">
            @if($article->is_breaking)
                <span class="article-hero__badge">🔴 BREAKING NEWS</span>
            @endif
            @if($article->category)
                <span class="article-hero__category">{{ $article->category->name }}</span>
            @endif
            <h1 class="article-hero__title">{{ $article->title }}</h1>
        </div>
    </div>
    @else
    <div class="article-no-hero">
        @if($article->category)
            <span class="article-hero__category">{{ $article->category->name }}</span>
        @endif
    </div>
    @endif

    {{-- ── ARTICLE BODY ── --}}
    <div class="article-body-wrap">

        {{-- Title (if no hero image) --}}
        @if(!$article->image)
        <h1 class="article-title-below">{{ $article->title }}</h1>
        @endif

        {{-- Meta Bar --}}
        <div class="article-meta-bar">
            <a href="{{ route('home') }}">← Beranda</a>
            <span class="article-meta-sep">|</span>
            <span>✍️ <strong>{{ $article->user ? $article->user->name : 'Redaksi FZN' }}</strong></span>
            <span class="article-meta-sep">•</span>
            <span>📅 {{ $article->published_at ? $article->published_at->format('d M Y, H:i') : '' }}</span>
            <span class="article-meta-sep">•</span>
            <span>🕒 {{ $article->published_at ? $article->published_at->diffForHumans() : '' }}</span>
            <span class="article-meta-sep">•</span>
            <span>👁️ {{ number_format($article->views_count) }}x dilihat</span>
        </div>

        {{-- Excerpt Highlight --}}
        @if($article->excerpt)
        <blockquote class="article-excerpt">
            "{{ $article->excerpt }}"
        </blockquote>
        @endif

        {{-- Main Content --}}
        <div class="article-content">
            {!! nl2br(e($article->content)) !!}
        </div>

        {{-- Footer Strip --}}
        <div class="article-footer-strip">
            <div class="article-views">
                👁️ {{ number_format($article->views_count) }} pembaca telah membaca artikel ini
            </div>
            @if($article->category)
            <span class="article-views">
                📂 {{ $article->category->name }}
            </span>
            @endif
        </div>

        {{-- Related Articles --}}
        @if(isset($relatedArticles) && count($relatedArticles) > 0)
        <div class="related-section">
            <h2 class="related-heading">Berita Lainnya</h2>
            <div class="related-heading-line"></div>

            <div class="related-grid">
                @foreach($relatedArticles as $rel)
                <a href="{{ route('news.detail', $rel->slug) }}" class="related-card">
                    <div class="related-card__img">
                        @if($rel->image)
                            <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title }}">
                        @else
                            <div class="related-card__placeholder">FZN NEWS</div>
                        @endif
                    </div>
                    <div class="related-card__body">
                        <div>
                            @if($rel->category)
                            <div class="related-card__cat">{{ $rel->category->name }}</div>
                            @endif
                            <div class="related-card__title">{{ $rel->title }}</div>
                        </div>
                        <div class="related-card__time">
                            🕒 {{ $rel->published_at ? $rel->published_at->diffForHumans() : '' }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
