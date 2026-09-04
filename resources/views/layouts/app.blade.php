<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FZN NEWS - Portal Berita Terkini">
    <title>FZN NEWS - Portal Berita Terkini</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    @stack('styles')
</head>
<body>
    {{-- Header Partial --}}
    @include('partials.header')

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer Partial --}}
    @include('partials.footer')

    {{-- Interactive News Detail Modal Popup --}}
    <div class="news-modal" id="news-modal">
        <div class="news-modal__card">
            <div class="news-modal__header">
                <button class="news-modal__close" id="modal-close-btn">&times;</button>
                <span class="news-modal__badge" id="modal-category">BERITA TERKINI</span>
                <h3 class="news-modal__title" id="modal-title">Judul Berita FZN NEWS</h3>
            </div>
            <div class="news-modal__body">
                <div id="modal-img-container" style="display:none; margin-bottom: 16px; border-radius: 10px; overflow: hidden; max-height: 280px; width: 100%;">
                    <img id="modal-image" src="" alt="Gambar Berita" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div class="news-modal__meta">
                    <span id="modal-date">📅 4 September 2026</span>
                    <span id="modal-author">✍️ Oleh Redaksi FZN</span>
                </div>
                <div class="news-modal__content" id="modal-content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </div>
            </div>
        </div>
    </div>

    {{-- Back to Top Floating Button --}}
    <button class="back-to-top" id="back-to-top-btn" aria-label="Kembali ke atas">↑</button>

    {{-- Interactive JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Sticky Header Scroll Effect
            const header = document.getElementById('main-header');
            const backToTop = document.getElementById('back-to-top-btn');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 100) {
                    header.classList.add('is-scrolled');
                } else if (window.scrollY < 20) {
                    header.classList.remove('is-scrolled');
                }

                if (window.scrollY > 300) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });

            // Back to top click
            backToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // 2. Interactive Modal Popup Setup
            const modal = document.getElementById('news-modal');
            const modalClose = document.getElementById('modal-close-btn');
            const modalTitle = document.getElementById('modal-title');
            const modalCategory = document.getElementById('modal-category');
            const modalDate = document.getElementById('modal-date');
            const modalAuthor = document.getElementById('modal-author');
            const modalContent = document.getElementById('modal-content');
            const modalImgContainer = document.getElementById('modal-img-container');
            const modalImage = document.getElementById('modal-image');

            function openModal(title, category, date, excerpt, image, author) {
                if (modalTitle) modalTitle.textContent = title || 'Judul Berita FZN NEWS';
                if (modalCategory) modalCategory.textContent = category || 'BERITA TERKINI';
                if (modalDate) modalDate.textContent = '📅 ' + (date || '4 September 2026');
                if (modalAuthor) modalAuthor.textContent = '✍️ Oleh ' + (author || 'Redaksi FZN');
                if (modalContent) modalContent.textContent = excerpt || 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

                if (modalImgContainer && modalImage) {
                    if (image && image.trim() !== '') {
                        modalImage.src = (image.startsWith('http') || image.startsWith('/')) ? image : '{{ asset("storage") }}/' + image;
                        modalImgContainer.style.display = 'block';
                    } else {
                        modalImgContainer.style.display = 'none';
                    }
                }

                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            if (modalClose) {
                modalClose.addEventListener('click', closeModal);
            }

            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal();
                });
            }

            // Expose globally for onclick calls
            window.openNewsModal = openModal;

            // 3. Breaking bar items navigate directly via <a> href — no modal needed
            // Hero cards navigate via onclick window.location.href — no modal needed
            // Modal is only kept as a utility if explicitly called via window.openNewsModal()

            // 4. Interactive Pagination Click
            document.querySelectorAll('.page-num').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.page-num').forEach(b => b.classList.remove('page-num--active'));
                    this.classList.add('page-num--active');
                });
            });

            // 5. Language Selector & Auto-Translate Logic
            const langBtn = document.getElementById('lang-btn');
            const langDropdown = document.getElementById('lang-dropdown');
            
            // Restore saved language preference on load
            const savedLang = localStorage.getItem('fzn_selected_lang') || 'id';
            const savedLabel = localStorage.getItem('fzn_selected_label');
            if (langBtn && savedLabel && savedLang !== 'id') {
                langBtn.innerHTML = `🌐 ${savedLabel} ▼`;
            }

            if (langBtn && langDropdown) {
                langBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    langDropdown.classList.toggle('active');
                });

                document.addEventListener('click', function () {
                    langDropdown.classList.remove('active');
                });

                // Attach click handlers to options
                langDropdown.querySelectorAll('a[data-lang]').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const langCode = this.getAttribute('data-lang');
                        const langLabel = this.getAttribute('data-label') || this.textContent.trim();

                        setLanguage(langCode, langLabel);
                    });
                });
            }

            function setLanguage(langCode, langLabel) {
                const domain = window.location.hostname;
                
                // Clear or set Google Translate cookie
                if (langCode === 'id') {
                    document.cookie = `googtrans=/id/id; path=/; domain=${domain}`;
                    document.cookie = `googtrans=/id/id; path=/;`;
                } else {
                    document.cookie = `googtrans=/id/${langCode}; path=/; domain=${domain}`;
                    document.cookie = `googtrans=/id/${langCode}; path=/;`;
                }

                localStorage.setItem('fzn_selected_lang', langCode);
                localStorage.setItem('fzn_selected_label', langLabel);

                // Update combo if element loaded
                const combo = document.querySelector('.goog-te-combo');
                if (combo) {
                    combo.value = langCode;
                    combo.dispatchEvent(new Event('change'));
                }
                
                location.reload();
            }

            // 6. Category Nav Links Active State (Navigasi URL dimungkinkan tanpa e.preventDefault)
            document.querySelectorAll('.header-box__nav-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    // Mengizinkan navigasi URL halaman dengan query parameter category
                });
            });

            // 7. Horizontal Scroll Controllers for Navbar & Breaking News
            function initHorizontalScroll(containerId, btnLeftId, btnRightId, scrollAmount) {
                const container = document.getElementById(containerId);
                const btnLeft = document.getElementById(btnLeftId);
                const btnRight = document.getElementById(btnRightId);

                if (!container || !btnLeft || !btnRight) return;

                function updateArrows() {
                    const scrollLeft = Math.round(container.scrollLeft);
                    const clientWidth = container.clientWidth;
                    const scrollWidth = container.scrollWidth;
                    const maxScrollLeft = Math.max(0, scrollWidth - clientWidth);

                    // Left arrow: ONLY show if user has scrolled at least 15px to the right
                    if (scrollLeft > 15 && maxScrollLeft > 10) {
                        btnLeft.classList.add('visible');
                    } else {
                        btnLeft.classList.remove('visible');
                    }

                    // Right arrow: ONLY show if there is scrollable content and not at far right end
                    if (maxScrollLeft > 10 && scrollLeft < (maxScrollLeft - 15)) {
                        btnRight.classList.add('visible');
                    } else {
                        btnRight.classList.remove('visible');
                    }
                }

                btnLeft.addEventListener('click', function (e) {
                    e.preventDefault();
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    setTimeout(updateArrows, 100);
                    setTimeout(updateArrows, 350);
                    setTimeout(updateArrows, 600);
                });

                btnRight.addEventListener('click', function (e) {
                    e.preventDefault();
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    setTimeout(updateArrows, 100);
                    setTimeout(updateArrows, 350);
                    setTimeout(updateArrows, 600);
                });

                container.addEventListener('scroll', updateArrows);
                if ('onscrollend' in window) {
                    container.addEventListener('scrollend', updateArrows);
                }
                window.addEventListener('resize', updateArrows);

                // Initial checks
                updateArrows();
                setTimeout(updateArrows, 100);
                setTimeout(updateArrows, 400);
            }

            initHorizontalScroll('nav-list', 'nav-scroll-left', 'nav-scroll-right', 180);
            initHorizontalScroll('breaking-container', 'breaking-scroll-left', 'breaking-scroll-right', 240);
        });
    </script>

    {{-- Hidden Google Translate Element & Initializer --}}
    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,ja,zh-CN,ar,es,fr,de,ko',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @stack('scripts')
</body>
</html>
