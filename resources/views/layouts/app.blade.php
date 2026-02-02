<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Drive Boosted | Elite Automotive Detailing & Performance Gear. Precision surface engineering and artisanal automotive care.">
    <meta name="keywords" content="car detailing, ceramic coating, ppf, paint protection, dhaka car care, premium detailing">
    <meta property="og:title" content="Drive Boosted | Elite Automotive Performance">
    <meta property="og:description" content="Precision surface engineering for the elite automotive enthusiast.">
    <meta property="og:image" content="{{ asset('images/hero.png') }}">
    <title>@yield('title', 'DriveBoosted | Premium Automotive Performance')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Font import handled by main.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{ time() }}">
    
    <script>
        // --- Drive Boosted Theme & Layout Engine ---
        (function() {
            const themeKey = 'db_theme';
            const savedTheme = localStorage.getItem(themeKey) || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            
            window.addEventListener('scroll', () => {
                const nav = document.querySelector('.master-nav');
                if (window.scrollY > 50) {
                    nav?.classList.add('scrolled');
                } else {
                    nav?.classList.remove('scrolled');
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                const themeToggle = document.getElementById('themeToggle');
                const mainLogo = document.getElementById('mainLogo');
                
                const updateThemeUI = (theme) => {
                    // Update Toggle Icon
                    const icon = themeToggle?.querySelector('i');
                    if(icon) {
                        icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
                    }
                    
                    // Update All Logos (Desktop & Mobile)
                    const logos = document.querySelectorAll('.logo-img');
                    const logoSrc = theme === 'light' ? '{{ asset("images/logo-black.png") }}' : '{{ asset("images/logo-white.png") }}';
                    logos.forEach(img => {
                        img.src = logoSrc;
                        img.onerror = function() {
                            this.src = theme === 'light' 
                                ? 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_BLACK.png?v=1768818786' 
                                : 'https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_WHITE.png?v=1768818786';
                        };
                    });
                };

                // Initial UI set
                updateThemeUI(savedTheme);

                if(themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        const current = document.documentElement.getAttribute('data-theme');
                        const target = current === 'dark' ? 'light' : 'dark';
                        
                        document.documentElement.setAttribute('data-theme', target);
                        localStorage.setItem(themeKey, target);
                        updateThemeUI(target);
                    });
                }
            });
        })();
    </script>
    @stack('styles')
</head>
<body>
    <div class="cart-drawer-overlay" id="cartOverlay" style="position:fixed; top:0; left:0; width:100%; height:100vh; background:rgba(0,0,0,0.8); z-index:1500; opacity:0; visibility:hidden; transition: 0.4s;"></div>

    <!-- Quick View Modal -->
    <div class="qv-overlay" id="quickViewOverlay">
        <button class="close-search" id="closeQuickView"><i class="fas fa-times"></i></button>
        <div class="qv-container" id="qvContent">
            <!-- Loaded via AJAX -->
        </div>
    </div>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        <span>WORLDWIDE SHIPPING • PREMIUM AUTOMOTIVE PERFORMANCE • EST. 2026</span>
    </div>

    <!-- Master Navigation -->
    <nav class="master-nav {{ Request::is('/') ? '' : 'glass-effect scrolled' }}" id="mainNav">
        <div class="nav-container d-flex align-items-center justify-content-between h-100">
            <!-- Left: Branding -->
            <div class="nav-left">
                <a href="{{ url('/') }}" class="logo-link">
                    <img src="{{ asset('images/logo-white.png') }}" alt="Drive Boosted" class="logo-img" id="mainLogo">
                </a>
            </div>
            
            <!-- Center: Desktop Navigation -->
            <ul class="nav-center d-none d-xl-flex gap-5 m-0 p-0 list-unstyled" id="navCenter">
                <li><a href="{{ url('/') }}" class="nav-link-rsa">HOME</a></li>
                <li class="has-megamenu">
                    <a href="{{ url('/catalog') }}" class="nav-link-rsa">GEAR SHOP <i class="fas fa-chevron-down ms-1" style="font-size: 0.6rem;"></i></a>
                    <div class="megamenu glass-effect">
                        <div class="nav-container py-5">
                            <div class="megamenu-grid">
                                @foreach(\App\Models\Category::take(5)->get() as $cat)
                                <div class="mm-category">
                                    <a href="{{ url('/catalog?category=' . $cat->slug) }}">
                                        <div class="mm-img-wrapper">
                                            <img src="{{ filter_var($cat->image, FILTER_VALIDATE_URL) ? $cat->image : asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" onerror="this.onerror=null;this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                                        </div>
                                        <h5 class="fw-900 fs-8 ls-1 text-uppercase mb-1">{{ $cat->name }}</h5>
                                        <p class="opacity-50 fs-9 m-0 text-truncate">{{ $cat->description ?? 'Explore premium gear' }}</p>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="{{ url('/catalog?category=ceramic') }}" class="nav-link-rsa">CERAMIC</a></li>
                <li><a href="{{ route('services.index') }}" class="nav-link-rsa">SERVICES</a></li>
                <li><a href="{{ url('/') }}#story" class="nav-link-rsa">OUR STORY</a></li>
            </ul>

            <!-- Right: Action Icons -->
            <div class="nav-right d-flex gap-4 align-items-center">
                <button class="nav-icon" id="themeToggle" title="Toggle Mode">
                    <i class="fas fa-sun"></i>
                </button>
                <div class="d-none d-md-block" style="width: 1px; height: 20px; background: var(--db-border-subtle);"></div>
                <button class="nav-icon" id="searchTrigger"><i class="fas fa-search"></i></button>
                <button class="nav-icon position-relative" id="cartTrigger">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-counter" id="cartCounter">{{ count(session('cart', [])) }}</span>
                </button>
                <button class="nav-icon d-xl-none" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </nav>

    <!-- Modal Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <button class="nav-icon position-absolute top-0 end-0 m-5" id="closeSearch" style="font-size: 2rem;"><i class="fas fa-times"></i></button>
        <div class="nav-container h-100 d-flex flex-column justify-content-center">
            <span class="fs-7 fw-900 ls-3 mb-4 opacity-30 d-block text-center uppercase">SEARCH THE SHOWROOM</span>
            <form action="{{ url('/catalog') }}" method="GET" class="w-100">
                <input type="text" name="q" id="searchInput" class="search-input-lg" placeholder="TYPE TO SEARCH..." autocomplete="off">
            </form>
            <div class="mt-5 text-center">
                <span class="fs-9 fw-900 opacity-20 ls-2 d-block mb-3 uppercase">POPULAR SEARCHES</span>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ url('/catalog?q=ceramic') }}" class="btn-pro btn-pro-outline py-2 px-4 fs-9">CERAMIC</a>
                    <a href="{{ url('/catalog?q=graphene') }}" class="btn-pro btn-pro-outline py-2 px-4 fs-9">GRAPHENE</a>
                    <a href="{{ url('/catalog?q=coating') }}" class="btn-pro btn-pro-outline py-2 px-4 fs-9">COATING</a>
                    <a href="{{ url('/catalog?q=microfiber') }}" class="btn-pro btn-pro-outline py-2 px-4 fs-9">MICROFIBER</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Drawer -->
    <div class="drawer-full glass-effect" id="cartDrawer">
        <div class="p-4 p-md-5 h-100 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fs-4 fw-900 ls-2 m-0 uppercase">GEAR BAG</h2>
                <button class="nav-icon" id="closeCart" style="font-size: 1.5rem;"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="flex-grow-1 overflow-auto pe-3" id="cartContents">
                @include('partials.cart-drawer-items')
            </div>

            <div class="mt-auto pt-5 border-top border-white border-opacity-10">
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-8 fw-900 opacity-40">ESTIMATED TOTAL</span>
                    <span class="fs-5 fw-900" id="drawerSubtotal">৳{{ number_format(collect(session('cart', []))->sum(fn($item) => $item['price'] * $item['quantity'])) }}</span>
                </div>
                <a href="{{ url('/cart') }}" class="btn-pro btn-pro-outline w-100 mb-3 py-3 fs-9">VIEW SHOPPING BAG</a>
                <a href="{{ url('/checkout') }}" class="btn-pro btn-pro-primary w-100 py-4 fs-8">INITIATE CHECKOUT</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Global Footer -->
    <footer class="mt-5 bg-elevated border-top border-white border-opacity-5 pt-12">
        <div class="nav-container">
            <div class="row g-5 pb-10">
                <div class="col-lg-4">
                    <a href="{{ url('/') }}" class="footer-logo mb-5 d-inline-block">DRIVE <span>BOOSTED</span></a>
                    <p class="fs-7 opacity-50 mb-5" style="max-width: 350px; line-height: 2;">
                        Elite automotive care and precision surface engineering. We redefine automotive aesthetics through scientific protocols and artisanal dedication.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="nav-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="nav-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="nav-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="nav-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="col-6 col-lg-2">
                    <h4 class="fs-8 fw-950 ls-2 mb-4 text-white">SHOP GEAR</h4>
                    <ul class="list-unstyled d-flex flex-column gap-3">
                        <li><a href="{{ url('/catalog') }}" class="footer-link-rsa">All Products</a></li>
                        <li><a href="{{ url('/catalog?category=ceramic') }}" class="footer-link-rsa">Ceramic Series</a></li>
                        <li><a href="{{ url('/catalog?category=maintenance') }}" class="footer-link-rsa">Maintenance</a></li>
                        <li><a href="{{ url('/catalog?category=accessories') }}" class="footer-link-rsa">Accessories</a></li>
                        <li><a href="{{ url('/catalog?category=kits') }}" class="footer-link-rsa">Detailing Kits</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h4 class="fs-8 fw-950 ls-2 mb-4 text-white">THE STUDIO</h4>
                    <ul class="list-unstyled d-flex flex-column gap-3">
                        <li><a href="{{ route('services.index') }}" class="footer-link-rsa">Service Lab</a></li>
                        <li><a href="{{ route('appointment.create') }}" class="footer-link-rsa">Book Session</a></li>
                        <li><a href="#" class="footer-link-rsa">Aftercare Guide</a></li>
                        <li><a href="#" class="footer-link-rsa">Our Story</a></li>
                        <li><a href="#" class="footer-link-rsa">Contact Lab</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h4 class="fs-8 fw-950 ls-2 mb-4 text-white">STAY PROTOCOL</h4>
                    <p class="fs-9 opacity-50 mb-5 ls-1">Join our high-performance circle for early access and tactical maintenance tips.</p>
                    <form action="#" class="newsletter-form-pro mb-5">
                        <div class="input-group">
                            <input type="email" class="form-control bg-surface border-white border-opacity-5 text-white fs-9" placeholder="ENTER@EMAIL_ADDRESS.COM" style="height: 55px;">
                            <button class="btn-pro btn-pro-primary px-4 fs-9" type="button">JOIN</button>
                        </div>
                    </form>
                    <div class="d-flex gap-3 opacity-30">
                        <i class="fab fa-cc-visa fs-3"></i>
                        <i class="fab fa-cc-mastercard fs-3"></i>
                        <i class="fab fa-cc-apple-pay fs-3"></i>
                        <i class="fab fa-cc-paypal fs-3"></i>
                    </div>
                </div>
            </div>
            
            <div class="border-top border-white border-opacity-5 py-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
                <p class="mb-0 fs-10 opacity-30 ls-3 text-uppercase">&copy; {{ date('Y') }} DRIVE BOOSTED APPAREL & CARE. ALL RIGHTS RESERVED.</p>
                <div class="d-flex gap-4 fs-10 opacity-30 ls-2 uppercase">
                    <a href="#" class="text-white text-decoration-none hover-opacity-100">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none hover-opacity-100">Terms of Service</a>
                    <a href="#" class="text-white text-decoration-none hover-opacity-100">Shipping Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // --- High-Performance Interactions ---
        $(document).ready(function() {
            const $nav = $('#mainNav');
            const $sidebar = $('#cartDrawer');
            const $search = $('#searchOverlay');
            const $menu = $('#navCenter');
            const $logo = $('#mainLogo');

            // Navigation Scroll Effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 30) {
                    $nav.addClass('scrolled');
                } else {
                    if(!window.location.pathname.match(/\/(#|$)/)) {
                        $nav.removeClass('scrolled');
                    }
                }
            });

            // Drawer & Overlay Controllers
            $('#cartTrigger').click(() => $sidebar.addClass('open'));
            $('#closeCart').click(() => $sidebar.removeClass('open'));
            
            $('#searchTrigger').click(() => {
                $search.addClass('active');
                setTimeout(() => $('#searchInput').focus(), 400);
            });
            $('#closeSearch').click(() => $search.removeClass('active'));

            $('#mobileMenuToggle').click(() => $menu.toggleClass('mobile-open'));

            // Scroll Reveal Intersection Observer
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            $('.reveal').each(function() { revealObserver.observe(this); });

            // AJAX Cart Integration
            $(document).on('submit', '.ajax-cart-form', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $btn = $form.find('button[type="submit"]');
                const originalText = $btn.html();
                
                $btn.prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin"></i>');
                
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        $('#cartCounter').text(res.cart_count);
                        $('#drawerSubtotal').text('৳' + res.cart_total);
                        $('#cartContents').html(res.html);
                        $sidebar.addClass('open');
                    },
                    error: () => console.error('Cart update failed'),
                    complete: () => $btn.prop('disabled', false).html(originalText)
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
