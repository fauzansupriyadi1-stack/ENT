<header class="header-outer" id="main-header">
    <div class="header-box">
        <div class="header-box__top">
            <h1 class="header-box__logo">
                <a href="{{ route('home') }}">FZN NEWS</a>
            </h1>
        </div>
        <div class="header-box__line"></div>
        <nav class="header-box__nav">
            <button class="nav-scroll-btn nav-scroll-btn--left" id="nav-scroll-left" aria-label="Scroll Kiri">❮</button>
            <ul class="header-box__nav-list" id="nav-list">
                @php
                    $currentCategory = $selectedCategory ?? request()->route('category') ?? request('category');
                @endphp
                <li>
                    <a href="{{ route('home') }}" class="header-box__nav-link {{ empty($currentCategory) ? 'active' : '' }}">
                        Semua
                    </a>
                </li>
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $cat)
                        @php
                            $catSlug = $cat->slug ?: \Illuminate\Support\Str::slug($cat->name);
                            $isActive = (strtolower((string)$currentCategory) === strtolower((string)$catSlug) || strtolower((string)$currentCategory) === strtolower((string)$cat->name));
                        @endphp
                        <li>
                            <a href="{{ route('category.show', ['category' => $catSlug]) }}" class="header-box__nav-link {{ $isActive ? 'active' : '' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                @else
                    @foreach(['National', 'Ekonomi', 'Tekno', 'Olahraga', 'Hiburan', 'Gaya Hidup'] as $catName)
                        @php
                            $catSlug = \Illuminate\Support\Str::slug($catName);
                            $isActive = (strtolower((string)$currentCategory) === strtolower((string)$catSlug) || strtolower((string)$currentCategory) === strtolower((string)$catName));
                        @endphp
                        <li>
                            <a href="{{ route('category.show', ['category' => $catSlug]) }}" class="header-box__nav-link {{ $isActive ? 'active' : '' }}">
                                {{ $catName }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <button class="nav-scroll-btn nav-scroll-btn--right" id="nav-scroll-right" aria-label="Scroll Kanan">❯</button>
        </nav>
    </div>
</header>
