<nav class="header-box__nav">
    <button class="nav-scroll-btn nav-scroll-btn--left" id="nav-scroll-left" aria-label="Scroll Kiri">❮</button>
    
    <ul class="header-box__nav-list" id="nav-list">
        @php
            // 1. Dapatkan kategori yang sedang aktif dari URL
            $currentCategory = strtolower(
                $selectedCategory ?? request()->route('category') ?? request('category')
            );

            // 2. Siapkan data kategori (dari database atau data default)
            $hasCategories = isset($categories) && count($categories) > 0;
            $menuItems = $hasCategories 
                ? $categories 
                : ['National', 'Ekonomi', 'Tekno', 'Olahraga', 'Hiburan', 'Gaya Hidup'];
        @endphp

        {{-- Link "Semua" --}}
        <li>
            <a href="{{ route('home') }}" class="header-box__nav-link {{ empty($currentCategory) ? 'active' : '' }}">
                Semua
            </a>
        </li>

        {{-- Loop Link Kategori --}}
        @foreach($menuItems as $item)
            @php
                // Ambil nama dan slug sesuai tipe data (object dari DB atau string)
                $name = is_object($item) ? $item->name : $item;
                $slug = is_object($item) && $item->slug ? $item->slug : \Illuminate\Support\Str::slug($name);
                
                // Tentukan apakah link kategori ini sedang aktif
                $isActive = ($currentCategory === strtolower($slug) || $currentCategory === strtolower($name));
            @endphp
            
            <li>
                <a href="{{ route('category.show', ['category' => $slug]) }}" class="header-box__nav-link {{ $isActive ? 'active' : '' }}">
                    {{ $name }}
                </a>
            </li>
        @endforeach
    </ul>

    <button class="nav-scroll-btn nav-scroll-btn--right" id="nav-scroll-right" aria-label="Scroll Kanan">❯</button>
</nav>
