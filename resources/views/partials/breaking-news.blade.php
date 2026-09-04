<section class="breaking-bar">
    <div class="breaking-bar__wrapper">
        @if(isset($breakingNews) && count($breakingNews) > 0)
            <button class="breaking-scroll-btn breaking-scroll-btn--left" id="breaking-scroll-left" aria-label="Scroll Kiri">❮</button>
            <div class="breaking-bar__container" id="breaking-container">
                @foreach($breakingNews as $index => $item)
                    <a href="{{ is_object($item) && isset($item->slug) ? route('news.detail', $item->slug) : '#' }}"
                       class="breaking-bar__item {{ $index === 0 ? 'breaking-bar__item--first' : '' }}"
                       style="text-decoration:none; color:inherit;">
                        @if(is_object($item) && $item->is_breaking)
                            <span class="badge-breaking">BREAKING</span>
                        @else
                            <span class="badge-latest">TERKINI</span>
                        @endif
                        <span class="time-meta">{{ is_object($item) && $item->published_at ? $item->published_at->diffForHumans() : '1 Jam yang lalu' }}</span>
                        <h3 class="breaking-headline">{{ is_object($item) ? $item->title : (is_array($item) ? $item['title'] : 'Judul berita') }}</h3>
                    </a>
                @endforeach
            </div>
            <button class="breaking-scroll-btn breaking-scroll-btn--right" id="breaking-scroll-right" aria-label="Scroll Kanan">❯</button>
        @endif
    </div>
</section>
