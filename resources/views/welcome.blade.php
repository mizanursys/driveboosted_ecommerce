@extends('layouts.app')

@section('title', 'Drive Boosted | Elite Automotive Performance')

@push('styles')
<style>
    /* Homepage Performance & Specialized Layout */
    .hero-section {
        background: var(--db-bg-body);
    }
    
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.4) 100%),
                    linear-gradient(to bottom, rgba(5,5,5,0.8) 0%, transparent 40%, rgba(5,5,5,0.8) 100%);
        z-index: 2;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background-size: cover !important;
        background-position: center !important;
        transition: transform 8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .swiper-slide-active .hero-bg {
        transform: scale(1.1);
    }

    .hero-content {
        position: relative;
        z-index: 3;
        max-width: 900px;
    }

    /* Aura Glow for Cards */
    .aura-glow {
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle at top right, var(--db-accent-glow), transparent 70%);
        opacity: 0;
        transition: var(--db-transition);
        pointer-events: none;
    }

    .product-card-pro:hover .aura-glow {
        opacity: 1;
    }

    /* Specialized Stat Layout */
    .stat-grid-modern {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1px;
        background: var(--db-border-subtle);
        border: 1px solid var(--db-border-subtle);
    }

    @media (min-width: 992px) {
        .stat-grid-modern {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .stat-item-pro {
        background: var(--db-bg-body);
        padding: 60px 40px;
        text-align: center;
        transition: var(--db-transition);
    }

    .stat-item-pro:hover {
        background: var(--db-bg-surface);
    }

    /* Category Blocks */
    .category-block {
        position: relative;
        height: 500px;
        overflow: hidden;
        background: var(--db-bg-surface);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        text-decoration: none !important;
        border: 1px solid var(--db-border-subtle);
    }

    .category-block-bg {
        position: absolute;
        inset: 0;
        background-size: cover !important;
        background-position: center !important;
        filter: brightness(0.5) grayscale(0.2);
        transition: var(--db-transition);
        z-index: 1;
    }

    .category-block:hover .category-block-bg {
        transform: scale(1.05);
        filter: brightness(0.7) grayscale(0);
    }

    .category-block-content {
        position: relative;
        z-index: 2;
    }
</style>
@endpush

@section('content')
    <!-- SECTION: CINEMATIC HERO -->
    <section class="hero-section position-relative overflow-hidden" style="height: 100vh;">
        <div class="swiper heroSwiper h-100">
            <div class="swiper-wrapper">
                <!-- Slide 1: Paint Correction -->
                <div class="swiper-slide">
                    <div class="hero-bg" style="background: url('https://images.unsplash.com/photo-1621370211603-9bb64be084cd?auto=format&fit=crop&q=80&w=2000')"></div>
                    <div class="hero-overlay"></div>
                    <div class="nav-container h-100 d-flex align-items-center">
                        <div class="hero-content reveal">
                            <span class="section-tag mb-4 shadow-text" style="color: var(--db-accent);">PROTOCOL_01 / RESTORATION</span>
                            <h1 class="display-1 ls-narrower text-white mb-4">BEYOND <span class="text-accent">GLOSS.</span></h1>
                            <p class="fs-5 text-white opacity-60 mb-5" style="max-width: 600px;">Precision surface engineering for the elite automotive enthusiast. We restore what time has taken.</p>
                            <div class="d-flex gap-4">
                                <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-primary">EXPLORE GEAR</a>
                                <a href="{{ route('appointment.create') }}" class="btn-pro btn-pro-outline">BOOK STUDIO</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Ceramic Coating -->
                <div class="swiper-slide">
                    <div class="hero-bg" style="background: url('https://images.unsplash.com/photo-1616763355548-1b606f439f86?auto=format&fit=crop&q=80&w=2000')"></div>
                    <div class="hero-overlay"></div>
                    <div class="nav-container h-100 d-flex align-items-center">
                        <div class="hero-content">
                            <span class="section-tag mb-4" style="color: var(--db-accent);">02 / PERMANENT ARMOR</span>
                            <h1 class="display-1 ls-narrower text-white mb-4">CERAMIC <span class="text-accent">GUARD.</span></h1>
                            <p class="fs-5 text-white opacity-60 mb-5" style="max-width: 600px;">Scientific covalent bonding providing hydrophobic depth that lasts for years. Unmatched protection.</p>
                            <a href="{{ url('/catalog?category=ceramic') }}" class="btn-pro btn-pro-primary">CERAMIC SERIES</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Controls -->
            <div class="nav-container position-absolute bottom-0 start-0 end-0 p-5 d-flex justify-content-between align-items-center z-3">
                <div class="hero-fraction text-white fw-900 fs-1 opacity-20"></div>
                <div class="d-flex gap-2">
                    <button class="btn-pro btn-pro-outline p-3 swiper-prev"><i class="fas fa-arrow-left"></i></button>
                    <button class="btn-pro btn-pro-outline p-3 swiper-next"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- SECTION: SCROLLING MARQUEE -->
    <div class="marquee-bar">
        <div class="marquee-content">
            <span class="marquee-item"><i class="fas fa-bolt"></i> WINTER CLEARANCE SALE: SAVE UP TO 15%</span>
            <span class="marquee-item"><i class="fas fa-bolt"></i> WINTER CLEARANCE SALE: SAVE UP TO 15%</span>
            <span class="marquee-item"><i class="fas fa-bolt"></i> WINTER CLEARANCE SALE: SAVE UP TO 15%</span>
            <span class="marquee-item"><i class="fas fa-bolt"></i> WINTER CLEARANCE SALE: SAVE UP TO 15%</span>
            <span class="marquee-item"><i class="fas fa-bolt"></i> WINTER CLEARANCE SALE: SAVE UP TO 15%</span>
            <span class="marquee-item"><i class="fas fa-bolt"></i> WINTER CLEARANCE SALE: SAVE UP TO 15%</span>
        </div>
    </div>
    
    <!-- SECTION: CIRCULAR CATEGORIES -->
    <section class="section-padding py-5 bg-body border-bottom border-white border-opacity-5">
        <div class="nav-container">
            <div class="text-center mb-5 reveal">
                <span class="section-tag mb-3" style="color: var(--db-accent);">THE_COLLECTION</span>
                <h2 class="display-4 ls-narrower m-0">SHOP BY CATEGORY_</h2>
            </div>
            
            <div class="category-scroll-container reveal">
                @foreach($categories as $cat)
                <a href="{{ url('/catalog?category=' . $cat->slug) }}" class="category-circle-wrapper">
                    <div class="cat-circle">
                        <img src="{{ filter_var($cat->image, FILTER_VALIDATE_URL) ? $cat->image : asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" onerror="this.onerror=null;this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                    </div>
                    <span class="cat-name">{{ $cat->name }}</span>
                </a>
                @endforeach
                <a href="{{ url('/catalog') }}" class="category-circle-wrapper">
                    <div class="cat-circle">
                         <i class="fas fa-arrow-right fs-4 text-primary"></i>
                    </div>
                    <span class="cat-name">All Items</span>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION: ELITE SERVICES -->
    <section class="section-padding bg-body border-bottom border-white border-opacity-5">
        <div class="nav-container">
            <div class="row align-items-end mb-5 reveal">
                <div class="col-lg-7">
                    <span class="section-tag mb-3" style="color: var(--db-accent);">DRIVE BOOSTED PROTOCOLS</span>
                    <h2 class="display-3 ls-narrower m-0">ELITE SERVICES_</h2>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('services.index') }}" class="btn-pro btn-pro-outline py-3 px-5 fs-9">VIEW LAB INDEX</a>
                </div>
            </div>

            <div class="row g-4">
                @foreach($services as $idx => $svc)
                <div class="col-lg-4">
                    <div class="service-card-modern reveal bg-surface border-white border-opacity-5 d-flex flex-column h-100" style="transition-delay: {{ $idx * 0.15 }}s;">
                        <a href="{{ route('services.show', $svc->id) }}" class="service-img-wrapper d-block overflow-hidden">
                            <img src="{{ $svc->image }}?auto=format&fit=crop&q=80&w=1000" alt="{{ $svc->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1605515298946-d062f2e9da53?auto=format&fit=crop&q=80&w=1000'" class="w-100 h-100 object-fit-cover transition-transform hover-scale">
                        </a>
                        <div class="p-5 flex-grow-1 d-flex flex-column">
                            <div class="mb-4">
                                <span class="fs-10 fw-950 text-accent ls-3 uppercase d-block mb-2">Starts From ৳{{ number_format($svc->price) }}</span>
                                <h3 class="fs-4 m-0"><a href="{{ route('services.show', $svc->id) }}" class="text-white text-decoration-none">{{ $svc->name }}</a></h3>
                            </div>
                            <p class="fs-7 opacity-50 mb-5 flex-grow-1" style="max-height: 80px; overflow: hidden;">{{ $svc->description }}</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('appointment.create', ['service' => $svc->id]) }}" class="btn-pro btn-pro-primary flex-grow-1 py-3 fs-9">BOOK NOW</a>
                                <a href="{{ route('services.show', $svc->id) }}" class="btn-pro btn-pro-outline py-3 px-3 fs-9"><i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION: PERFORMANCE METRICS -->
    <section class="stat-grid-modern reveal">
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">5K+</span>
            <span class="section-tag opacity-40">Cars Perfected</span>
        </div>
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">9H</span>
            <span class="section-tag opacity-40">Standard Hardness</span>
        </div>
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">10Y+</span>
            <span class="section-tag opacity-40">Protection Life</span>
        </div>
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">100%</span>
            <span class="section-tag opacity-40">Artisanal Finish</span>
        </div>
    </section>


    <!-- SECTION: PRODUCT SHOWROOM -->
    <section class="section-padding bg-surface">
        <div class="nav-container">
            <div class="d-flex justify-content-between align-items-end mb-5 reveal">
                <div>
                    <span class="section-tag mb-3" style="color: var(--db-accent);">GEAR_REGISTRY</span>
                    <h2 class="display-4 ls-narrower m-0">THE SHOP_</h2>
                </div>
                <a href="{{ url('/catalog') }}" class="nav-link-rsa p-0 border-bottom border-accent">BROWSE ALL GEAR →</a>
            </div>

            <div class="product-grid reveal">
                @foreach($products as $product)
                <div class="product-card-rsa group-hover-trigger">
                    <div class="sale-badge">SALE</div>
                    <a href="{{ route('product.show', $product->slug) }}" class="rsa-card-image d-block">
                        <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}?auto=format&q=80&w=600" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                    </a>
                    <div class="rsa-card-body">
                        <h3 class="rsa-card-title">{{ $product->name }}</h3>
                        <div class="rsa-card-price">
                            <span class="price-current">৳{{ number_format($product->price) }}</span>
                            <span class="price-old">৳{{ number_format($product->price * 1.2) }}</span>
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-cart-form m-0 mt-auto">
                            @csrf
                            <button type="submit" class="btn-rsa-cart">
                                Add to cart
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION: SPLIT SHOWCASE -->
    <section class="section-padding p-0 bg-body">
        <div class="row g-0">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="service-img-wrapper h-100" style="min-height: 600px;">
                    <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&q=80&w=2000" class="reveal h-100 w-100 object-fit-cover" alt="Performance">
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center p-5 p-lg-12 bg-surface order-1 order-lg-2">
                <div class="reveal">
                    <span class="section-tag mb-4" style="color: var(--db-accent);">THE STANDARD</span>
                    <h2 class="display-3 ls-narrower mb-4">ENGINEERED<br>PRECISION_</h2>
                    <p class="fs-6 opacity-50 mb-5" style="line-height: 2;">Drive Boosted operates at the intersection of high-performance chemical engineering and artisanal automotive care. We don't just detail; we preserve, protect, and perfect every micron of your vehicle's surface.</p>
                    <div class="d-flex gap-5 mb-5">
                        <div>
                            <span class="d-block fs-3 fw-900 text-primary mb-1">9H</span>
                            <span class="fs-10 fw-950 opacity-30 ls-2 uppercase">Coating Base</span>
                        </div>
                        <div>
                            <span class="d-block fs-3 fw-900 text-primary mb-1">100%</span>
                            <span class="fs-10 fw-950 opacity-30 ls-2 uppercase">Lab Tested</span>
                        </div>
                    </div>
                    <a href="{{ url('/') }}#story" class="btn-pro btn-pro-primary px-5 py-4">OUR MISSION</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const swiper = new Swiper(".heroSwiper", {
            loop: true,
            speed: 1200,
            autoplay: { delay: 7000, disableOnInteraction: false },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: {
                el: ".hero-fraction",
                type: 'fraction',
                formatFractionCurrent: (num) => '0' + num,
                formatFractionTotal: (num) => '0' + num
            },
            navigation: {
                nextEl: ".swiper-next",
                prevEl: ".swiper-prev"
            }
        });
    });
</script>
@endpush
