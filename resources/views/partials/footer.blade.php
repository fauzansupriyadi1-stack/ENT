<footer class="site-footer" id="site-footer">
    <div class="site-footer__container">
        <div class="site-footer__top">
            <div class="site-footer__logo">FZN NEWS</div>
            <ul class="site-footer__nav">
                @php
                    $currentCategory = $selectedCategory ?? request()->route('category') ?? request('category');
                @endphp
                <li>
                    <a href="{{ route('home') }}" class="{{ empty($currentCategory) ? 'active' : '' }}">
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
                            <a href="{{ route('category.show', ['category' => $catSlug]) }}" class="{{ $isActive ? 'active' : '' }}">
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
                            <a href="{{ route('category.show', ['category' => $catSlug]) }}" class="{{ $isActive ? 'active' : '' }}">
                                {{ $catName }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="site-footer__bottom">
            <button class="site-footer__lang-btn" id="lang-btn">
                🌐 FZN Di bahasa lain ▼
            </button>
            <div class="lang-dropdown" id="lang-dropdown">
                <a href="javascript:void(0)" data-lang="id" data-label="Bahasa Indonesia">🇮🇩 Bahasa Indonesia</a>
                <a href="javascript:void(0)" data-lang="en" data-label="English (US)">🇺🇸 English (US)</a>
                <a href="javascript:void(0)" data-lang="ja" data-label="日本語">🇯🇵 日本語</a>
                <a href="javascript:void(0)" data-lang="en" data-label="English (SG)">🇸🇬 English (SG)</a>
                <a href="javascript:void(0)" data-lang="zh-CN" data-label="中文 (Simplified)">🇨🇳 中文</a>
                <a href="javascript:void(0)" data-lang="ar" data-label="العربية">🇸🇦 العربية</a>
            </div>
        </div>
    </div>
</footer>
