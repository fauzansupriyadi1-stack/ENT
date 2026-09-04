@if(!empty($moreNewsTall))
<section class="more-section">
    <div class="more-container">
        <h2 class="more-heading">More News</h2>

        <div class="more-grid{{ empty($moreNewsGrid) ? ' more-grid--single' : '' }}">
            {{-- Left Tall Green Card --}}
            <div class="more-card-tall" style="cursor:pointer;" onclick="window.location.href='{{ isset($moreNewsTall['slug']) ? route('news.detail', $moreNewsTall['slug']) : '#' }}'">
                <div class="more-card-tall__img">
                    @if(!empty($moreNewsTall['image']))
                        <img src="{{ asset('storage/' . $moreNewsTall['image']) }}" alt="{{ $moreNewsTall['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>{{ $moreNewsTall['slot'] ?? 'FOTO' }}</span>
                    @endif
                </div>
                <div class="more-card-tall__body">
                    <div class="card-category-header">
                        <a href="{{ isset($moreNewsTall['slug']) ? route('news.detail', $moreNewsTall['slug']) : '#' }}" class="btn-detail btn-detail--white">LIHAT DETAIL</a>
                        @if(!empty($moreNewsTall['category']))
                            <span class="category-badge category-badge--white">{{ $moreNewsTall['category'] }}</span>
                        @endif
                        @if(isset($moreNewsTall['published_at']) && $moreNewsTall['published_at'])
                            <span class="time-meta time-meta--white">🕒 {{ $moreNewsTall['published_at']->diffForHumans() }}</span>
                        @endif
                    </div>
                    <h3 class="more-card-tall__title">{{ $moreNewsTall['title'] ?? '' }}</h3>
                    <p class="more-card-tall__excerpt">{{ $moreNewsTall['excerpt'] ?? '' }}</p>
                </div>
            </div>

            {{-- Middle Column Cards (only if grid has items) --}}
            @if(!empty($moreNewsGrid))
            <div class="more-col">
                @foreach(array_slice($moreNewsGrid, 0, 2) as $item)
                <div class="more-card" style="cursor:pointer;" onclick="window.location.href='{{ isset($item['slug']) ? route('news.detail', $item['slug']) : '#' }}'">
                    <div class="more-card__img">
                        @if(!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span>{{ $item['slot'] ?? '' }}</span>
                        @endif
                    </div>
                    <div class="more-card__body">
                        <div class="card-category-header" style="margin-bottom:4px;">
                            @if(!empty($item['category']))
                                <span class="category-badge category-badge--sm category-badge--dark">{{ $item['category'] }}</span>
                            @endif
                            <span class="time-meta time-meta--dark">🕒 {{ !empty($item['published_at']) && is_object($item['published_at']) ? $item['published_at']->diffForHumans() : ($item['date'] ?? '') }}</span>
                        </div>
                        <h4 class="more-card__title">{{ $item['title'] ?? '' }}</h4>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Right Column Cards --}}
            @php $rightItems = array_slice($moreNewsGrid, 2, 2); @endphp
            @if(!empty($rightItems))
            <div class="more-col">
                @foreach($rightItems as $item)
                <div class="more-card" style="cursor:pointer;" onclick="window.location.href='{{ isset($item['slug']) ? route('news.detail', $item['slug']) : '#' }}'">
                    <div class="more-card__img">
                        @if(!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span>{{ $item['slot'] ?? '' }}</span>
                        @endif
                    </div>
                    <div class="more-card__body">
                        <div class="card-category-header" style="margin-bottom:4px;">
                            @if(!empty($item['category']))
                                <span class="category-badge category-badge--sm category-badge--dark">{{ $item['category'] }}</span>
                            @endif
                            <span class="time-meta time-meta--dark">🕒 {{ !empty($item['published_at']) && is_object($item['published_at']) ? $item['published_at']->diffForHumans() : ($item['date'] ?? '') }}</span>
                        </div>
                        <h4 class="more-card__title">{{ $item['title'] ?? '' }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @endif
        </div>

        {{-- DYNAMIC PAGINATION --}}
        @if(isset($moreNewsPaginator) && $moreNewsPaginator->lastPage() > 1)
        <div class="pagination-bar">
            {{-- Previous --}}
            @if($moreNewsPaginator->onFirstPage())
                <span class="page-arrow page-arrow--disabled">❮</span>
            @else
                <a href="{{ $moreNewsPaginator->previousPageUrl() }}" class="page-arrow">❮</a>
            @endif

            {{-- Page numbers --}}
            @php
                $currentPage = $moreNewsPaginator->currentPage();
                $lastPage    = $moreNewsPaginator->lastPage();
                $window      = 2; // pages on each side of current
                $start       = max(1, $currentPage - $window);
                $end         = min($lastPage, $currentPage + $window);
            @endphp

            {{-- First page + ellipsis --}}
            @if($start > 1)
                <a href="{{ $moreNewsPaginator->url(1) }}" class="page-num">1</a>
                @if($start > 2)
                    <span class="page-dots">…</span>
                @endif
            @endif

            {{-- Window pages --}}
            @for($p = $start; $p <= $end; $p++)
                @if($p === $currentPage)
                    <span class="page-num page-num--active">{{ $p }}</span>
                @else
                    <a href="{{ $moreNewsPaginator->url($p) }}" class="page-num">{{ $p }}</a>
                @endif
            @endfor

            {{-- Last page + ellipsis --}}
            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="page-dots">…</span>
                @endif
                <a href="{{ $moreNewsPaginator->url($lastPage) }}" class="page-num">{{ $lastPage }}</a>
            @endif

            {{-- Next --}}
            @if($moreNewsPaginator->hasMorePages())
                <a href="{{ $moreNewsPaginator->nextPageUrl() }}" class="page-arrow">❯</a>
            @else
                <span class="page-arrow page-arrow--disabled">❯</span>
            @endif
        </div>
        @endif

    </div>
</section>
@endif
