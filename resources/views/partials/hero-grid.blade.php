<section class="hero-section">
    <div class="hero-container">

        @php
            $hasAnyArticle = collect($heroArticles)->filter(fn($a) => !is_null($a['title'] ?? null))->count() > 0;
            $foto1 = $heroArticles[1] ?? null;
            $foto2 = $heroArticles[2] ?? null;
            $foto3 = $heroArticles[3] ?? null;
            $foto4 = $heroArticles[4] ?? null;
            $foto5 = $heroArticles[5] ?? null;
            $foto6 = $heroArticles[6] ?? null;
            $foto7 = $heroArticles[7] ?? null;
            $foto8 = $heroArticles[8] ?? null;
        @endphp

        @if(!isset($heroArticles) || count($heroArticles) === 0)

            {{-- EMPTY STATE --}}
            <div style="width:100%; padding: 70px 20px; text-align:center; color:#64748b; background-color: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 14px; margin: 20px 0;">
                <div style="font-size:3rem; margin-bottom:12px;">📂</div>
                <h2 style="font-size:1.3rem; font-weight:700; color:#334155; margin-bottom:6px;">
                    Kategori {{ !empty($selectedCategory) ? ucfirst($selectedCategory) : '' }} Ini Masih Kosong
                </h2>
                <p style="font-size:0.88rem; color:#64748b;">Belum ada berita yang dipublikasikan pada kategori ini.</p>
            </div>

        @else

        {{-- COLUMN 1 (LEFT) --}}
        @if($foto1 || $foto7 || $foto8)
        <div class="hero-col hero-col--left">
            {{-- FOTO 1 --}}
            @if($foto1)
            <div class="card-hero card-foto1" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto1['slug']) ? route('news.detail', $foto1['slug']) : '#' }}'">
                <div class="card-hero__divider card-hero__divider--top"></div>
                <div class="card-hero__img card-hero__img--green">
                    @if(!empty($foto1['image']))
                        <img src="{{ asset('storage/' . $foto1['image']) }}" alt="{{ $foto1['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>FOTO 1</span>
                    @endif
                </div>
                <div class="card-hero__body">
                    <div class="card-category-header">
                        <a href="{{ isset($foto1['slug']) ? route('news.detail', $foto1['slug']) : '#' }}" class="btn-detail btn-detail--dark">LIHAT DETAIL</a>
                        @if(!empty($foto1['category']))
                            <span class="category-badge category-badge--dark">{{ $foto1['category'] }}</span>
                        @endif
                        @if(!empty($foto1['published_at']))
                            <span class="time-meta time-meta--dark">🕒 {{ is_object($foto1['published_at']) ? $foto1['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto1['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h2 class="card-title card-title--dark">{{ $foto1['title'] ?? '' }}</h2>
                </div>
            </div>
            @endif

            {{-- FOTO 7 & FOTO 8 COMBINED NOTCHED CARD --}}
            @if($foto7 || $foto8)
            @php
                $fotoRight = $foto8 ?? $foto7;
            @endphp
            <div class="card-foto7-author-combined hero-card-clickable">
                <div class="notch notch--tl"></div>
                <div class="notch notch--br"></div>

                {{-- LEFT SIDE: FOTO 7 (Image, LIHAT DETAIL & Category) --}}
                @if($foto7)
                <div class="combined-left" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto7['slug']) ? route('news.detail', $foto7['slug']) : '#' }}'">
                    <div class="card-green-notched__img-white card-green-notched__img-white--foto7">
                        @if(!empty($foto7['image']))
                            <img src="{{ asset('storage/' . $foto7['image']) }}" alt="{{ $foto7['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span>FOTO 7</span>
                        @endif
                    </div>
                    <div class="combined-left__body">
                        <div class="card-category-header">
                            <a href="{{ isset($foto7['slug']) ? route('news.detail', $foto7['slug']) : '#' }}" class="btn-detail btn-detail--white btn-detail--sm">LIHAT DETAIL</a>
                            @if(!empty($foto7['category']))
                                <span class="category-badge category-badge--sm category-badge--white">{{ $foto7['category'] }}</span>
                            @endif
                            @if(!empty($foto7['published_at']))
                                <span class="time-meta time-meta--white" style="font-size:0.6rem;">🕒 {{ is_object($foto7['published_at']) ? $foto7['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto7['published_at'])->diffForHumans() }}</span>
                            @endif
                        </div>
                        <h3 class="card-title card-title--white card-title--sm">{{ $foto7['title'] ?? '' }}</h3>
                    </div>
                </div>
                @endif

                {{-- RIGHT SIDE: FOTO 8 (LIHAT DETAIL, Category, Title & Excerpt) --}}
                @if($fotoRight)
                <div class="combined-right" style="cursor:pointer;" onclick="window.location.href='{{ isset($fotoRight['slug']) ? route('news.detail', $fotoRight['slug']) : '#' }}'">
                    <div class="card-category-header" style="margin-bottom:6px;">
                        <a href="{{ isset($fotoRight['slug']) ? route('news.detail', $fotoRight['slug']) : '#' }}" class="btn-detail btn-detail--white btn-detail--sm">LIHAT DETAIL</a>
                        @if(!empty($fotoRight['category']))
                            <span class="category-badge category-badge--sm category-badge--white">{{ $fotoRight['category'] }}</span>
                        @endif
                        @if(!empty($fotoRight['published_at']))
                            <span class="time-meta time-meta--white" style="font-size:0.6rem;">🕒 {{ is_object($fotoRight['published_at']) ? $fotoRight['published_at']->diffForHumans() : \Carbon\Carbon::parse($fotoRight['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h3 class="card-author__title">{{ $fotoRight['title'] ?? '' }}</h3>
                    <p class="card-author__p">{{ $fotoRight['excerpt'] ?? '' }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif

        {{-- COLUMN 2 (MIDDLE) --}}
        @if($foto2 || $foto6)
        <div class="hero-col hero-col--mid">
            {{-- FOTO 2 --}}
            @if($foto2)
            <div class="card-green-notched card-foto2-notched" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto2['slug']) ? route('news.detail', $foto2['slug']) : '#' }}'">
                <div class="notch notch--tl"></div>
                <div class="notch notch--tr"></div>
                <div class="notch notch--bl"></div>
                <div class="notch notch--br"></div>
                <div class="card-green-notched__img-white card-green-notched__img-white--lg">
                    @if(!empty($foto2['image']))
                        <img src="{{ asset('storage/' . $foto2['image']) }}" alt="{{ $foto2['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>FOTO 2</span>
                    @endif
                </div>
                <div class="card-green-notched__body">
                    <div class="card-category-header">
                        <a href="{{ isset($foto2['slug']) ? route('news.detail', $foto2['slug']) : '#' }}" class="btn-detail btn-detail--white">LIHAT DETAIL</a>
                        @if(!empty($foto2['category']))
                            <span class="category-badge category-badge--white">{{ $foto2['category'] }}</span>
                        @endif
                        @if(!empty($foto2['published_at']))
                            <span class="time-meta time-meta--white">🕒 {{ is_object($foto2['published_at']) ? $foto2['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto2['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h2 class="card-title card-title--white">{{ $foto2['title'] ?? '' }}</h2>
                </div>
            </div>
            @endif

            {{-- FOTO 6 --}}
            @if($foto6)
            <div class="card-hero card-foto6-mid" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto6['slug']) ? route('news.detail', $foto6['slug']) : '#' }}'">
                <div class="card-hero__img card-hero__img--green card-hero__img--tall">
                    @if(!empty($foto6['image']))
                        <img src="{{ asset('storage/' . $foto6['image']) }}" alt="{{ $foto6['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>FOTO 6</span>
                    @endif
                </div>
                <div class="card-hero__body">
                    <div class="card-category-header">
                        <a href="{{ isset($foto6['slug']) ? route('news.detail', $foto6['slug']) : '#' }}" class="btn-detail btn-detail--dark">LIHAT DETAIL</a>
                        @if(!empty($foto6['category']))
                            <span class="category-badge category-badge--dark">{{ $foto6['category'] }}</span>
                        @endif
                        @if(!empty($foto6['published_at']))
                            <span class="time-meta time-meta--dark">🕒 {{ is_object($foto6['published_at']) ? $foto6['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto6['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h2 class="card-title card-title--dark">{{ $foto6['title'] ?? '' }}</h2>
                </div>
                <div class="card-hero__divider"></div>
            </div>
            @endif
        </div>
        @endif

        {{-- COLUMN 3 (RIGHT) --}}
        @if($foto3 || $foto4 || $foto5)
        <div class="hero-col hero-col--right">
            {{-- FOTO 3 --}}
            @if($foto3)
            <div class="card-hero card-foto3" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto3['slug']) ? route('news.detail', $foto3['slug']) : '#' }}'">
                <div class="card-hero__divider card-hero__divider--top"></div>
                <div class="card-hero__img card-hero__img--green card-hero__img--sm">
                    @if(!empty($foto3['image']))
                        <img src="{{ asset('storage/' . $foto3['image']) }}" alt="{{ $foto3['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>FOTO 3</span>
                    @endif
                </div>
                <div class="card-hero__body card-hero__body--sm">
                    <div class="card-category-header">
                        <a href="{{ isset($foto3['slug']) ? route('news.detail', $foto3['slug']) : '#' }}" class="btn-detail btn-detail--dark btn-detail--sm">LIHAT DETAIL</a>
                        @if(!empty($foto3['category']))
                            <span class="category-badge category-badge--sm category-badge--dark">{{ $foto3['category'] }}</span>
                        @endif
                        @if(!empty($foto3['published_at']))
                            <span class="time-meta time-meta--dark" style="font-size:0.6rem;">🕒 {{ is_object($foto3['published_at']) ? $foto3['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto3['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h4 class="card-title card-title--dark card-title--sm">{{ $foto3['title'] ?? '' }}</h4>
                </div>
                <div class="card-hero__divider"></div>
            </div>
            @endif

            {{-- FOTO 4 --}}
            @if($foto4)
            <div class="card-hero card-foto4" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto4['slug']) ? route('news.detail', $foto4['slug']) : '#' }}'">
                <div class="card-hero__img card-hero__img--green card-hero__img--sm">
                    @if(!empty($foto4['image']))
                        <img src="{{ asset('storage/' . $foto4['image']) }}" alt="{{ $foto4['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>FOTO 4</span>
                    @endif
                </div>
                <div class="card-hero__body card-hero__body--sm">
                    <div class="card-category-header">
                        <a href="{{ isset($foto4['slug']) ? route('news.detail', $foto4['slug']) : '#' }}" class="btn-detail btn-detail--dark btn-detail--sm">LIHAT DETAIL</a>
                        @if(!empty($foto4['category']))
                            <span class="category-badge category-badge--sm category-badge--dark">{{ $foto4['category'] }}</span>
                        @endif
                        @if(!empty($foto4['published_at']))
                            <span class="time-meta time-meta--dark" style="font-size:0.6rem;">🕒 {{ is_object($foto4['published_at']) ? $foto4['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto4['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h4 class="card-title card-title--dark card-title--sm">{{ $foto4['title'] ?? '' }}</h4>
                </div>
            </div>
            @endif

            {{-- FOTO 5 --}}
            @if($foto5)
            <div class="card-green-notched card-foto5-notched" style="cursor:pointer;" onclick="window.location.href='{{ isset($foto5['slug']) ? route('news.detail', $foto5['slug']) : '#' }}'">
                <div class="notch notch--tl"></div>
                <div class="notch notch--bl"></div>
                <div class="notch notch--br"></div>
                <div class="card-green-notched__img-white card-green-notched__img-white--sm">
                    @if(!empty($foto5['image']))
                        <img src="{{ asset('storage/' . $foto5['image']) }}" alt="{{ $foto5['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>FOTO 5</span>
                    @endif
                </div>
                <div class="card-green-notched__body card-green-notched__body--sm">
                    <div class="card-category-header">
                        <a href="{{ isset($foto5['slug']) ? route('news.detail', $foto5['slug']) : '#' }}" class="btn-detail btn-detail--white btn-detail--sm">LIHAT DETAIL</a>
                        @if(!empty($foto5['category']))
                            <span class="category-badge category-badge--sm category-badge--white">{{ $foto5['category'] }}</span>
                        @endif
                        @if(!empty($foto5['published_at']))
                            <span class="time-meta time-meta--white" style="font-size:0.6rem;">🕒 {{ is_object($foto5['published_at']) ? $foto5['published_at']->diffForHumans() : \Carbon\Carbon::parse($foto5['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h4 class="card-title card-title--white card-title--sm">{{ $foto5['title'] ?? '' }}</h4>
                </div>
            </div>
            @endif
        </div>
        @endif

        @endif

    </div>
</section>
