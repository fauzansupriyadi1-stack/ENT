<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - FZN NEWS</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">

    @stack('styles')
</head>
<body class="admin-body">

    {{-- Mobile Sidebar Overlay --}}
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="admin-layout">
        
        {{-- SIDEBAR --}}
        <aside class="admin-sidebar" id="admin-sidebar">
            <div class="admin-sidebar__brand">
                <h2>FZN NEWS</h2>
                <span>ADMIN PANEL</span>
            </div>

            <nav class="admin-sidebar__nav">
                <ul>
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">📊 Dashboard & Grafik</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.post-berita') ? 'active' : '' }}">
                        <a href="{{ route('admin.post-berita') }}">📝 Post Berita Baru</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.layout-mapping') ? 'active' : '' }}">
                        <a href="{{ route('admin.layout-mapping') }}">⚡ Layout Mapping Hero</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.kelola-berita') ? 'active' : '' }}">
                        <a href="{{ route('admin.kelola-berita') }}">📰 Kelola Berita</a>
                    </li>
                    <li><a href="#">📁 Kategori Berita</a></li>
                    <li><a href="#">👤 Pengguna Admin</a></li>
                    <li><a href="#">⚙️ Pengaturan</a></li>
                </ul>
            </nav>

            <div class="admin-sidebar__footer">
                <a href="{{ route('home') }}" class="btn-front" target="_blank">🌐 Lihat Landing Page</a>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="admin-main">
            
            {{-- TOPBAR --}}
            <header class="admin-topbar">
                <div style="display:flex; align-items:center; gap:12px; min-width:0; flex:1;">
                    {{-- Mobile Hamburger --}}
                    <button class="admin-hamburger" id="hamburger-btn" aria-label="Buka menu sidebar">☰</button>
                    <div class="admin-topbar__title">
                        <h1>@yield('page_title', 'Dashboard')</h1>
                        <p>@yield('page_subtitle', 'Kelola portal berita FZN NEWS')</p>
                    </div>
                </div>
                <div class="admin-topbar__actions">
                    @if (!request()->routeIs('admin.post-berita'))
                        <a href="{{ route('admin.post-berita') }}" class="btn-primary">+ Post Berita</a>
                    @endif
                    <div class="admin-profile">
                        <div class="admin-avatar">A</div>
                        <div class="admin-info">
                            <strong>Fauzan Admin</strong>
                            <span>Super Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- DYNAMIC PAGE CONTENT --}}
            @yield('content')

        </main>
    </div>

    {{-- Mobile Sidebar Toggle Script --}}
    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const hamburger = document.getElementById('hamburger-btn');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        hamburger.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Close sidebar when a nav link is clicked on mobile
        document.querySelectorAll('.admin-sidebar__nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) closeSidebar();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
