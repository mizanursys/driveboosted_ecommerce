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

    /* Full Image Service Card */
    .service-card-full {
        position: relative;
        height: 450px;
        border-radius: 4px; /* Slight rounding or 0 for sharp */
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: var(--db-transition);
    }

    .service-card-bg {
        position: absolute;
        inset: 0;
        z-index: 1;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .service-card-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.6) 50%, transparent 100%);
        opacity: 0.9;
        transition: var(--db-transition);
    }

    .service-card-full:hover {
        border-color: var(--db-accent);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .service-card-full:hover .service-card-bg {
        transform: scale(1.1);
    }

    .service-card-full:hover .service-card-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
        opacity: 1;
    }

    .service-action-btns {
        transform: translateY(10px);
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .service-card-full:hover .service-action-btns {
        transform: translateY(0);
        opacity: 1;
    }
</style>
@endpush

@section('content')
    <!-- SECTION: CINEMATIC HERO -->
    <section class="hero-section position-relative overflow-hidden" style="height: 100vh;">
        <div class="swiper heroSwiper h-100">
            <div class="swiper-wrapper">
                @foreach($hero_slides as $slide)
                <div class="swiper-slide">
                    <div class="hero-bg" style="background: url('{{ filter_var($slide->image, FILTER_VALIDATE_URL) ? $slide->image : asset('storage/' . $slide->image) }}')"></div>
                    <div class="hero-overlay"></div>
                    <div class="nav-container h-100 d-flex align-items-center">
                        <div class="hero-content reveal">
                            @if($slide->subtitle)
                                <span class="section-tag mb-4 shadow-text" style="color: var(--db-accent);">{{ $slide->subtitle }}</span>
                            @endif
                            <h1 class="display-1 ls-narrower text-white mb-4">{!! nl2br($slide->title) !!}</h1>
                            @if($slide->description)
                                <p class="fs-5 text-white opacity-60 mb-5" style="max-width: 600px;">{!! nl2br($slide->description) !!}</p>
                            @endif
                            @if($slide->button_text && $slide->button_link)
                            <div class="d-flex gap-4">
                                <a href="{{ $slide->button_link }}" class="btn-pro btn-pro-primary">{{ $slide->button_text }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
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
            @for($i=0; $i<10; $i++)
                <span class="marquee-item"><i class="fas fa-bolt"></i> {{ $site_settings->marquee_text ?? 'WINTER CLEARANCE SALE: SAVE UP TO 15%' }}</span>
            @endfor
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
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-full reveal" style="transition-delay: {{ $idx * 0.1 }}s;">
                        <!-- Background Image -->
                        <div class="service-card-bg">
                            <img src="{{ filter_var($svc->image, FILTER_VALIDATE_URL) ? $svc->image : asset($svc->image) }}" 
                                 alt="{{ $svc->name }}" 
                                 class="w-100 h-100 object-fit-cover"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1605515298946-d062f2e9da53?auto=format&fit=crop&q=80&w=1000'">
                        </div>
                        
                        <!-- Overlay & Content -->
                        <div class="service-card-overlay">
                            <div class="d-flex flex-column h-100 justify-content-end p-4">
                                <span class="badge bg-accent text-black rounded-0 w-auto align-self-start mb-3 fw-bold ls-1">
                                    STARTING FROM ৳{{ number_format($svc->price) }}
                                </span>
                                
                                <h3 class="fs-4 fw-bold text-white mb-2">{{ $svc->name }}</h3>
                                
                                <p class="text-white opacity-70 fs-8 mb-4 service-desc-truncate">
                                    {{ Str::limit($svc->description, 80) }}
                                </p>
                                
                                <div class="d-flex gap-2 service-action-btns">
                                    <a href="{{ route('appointment.create', ['service' => $svc->id]) }}" class="btn-pro btn-pro-primary flex-grow-1 py-3 fs-9 text-center">
                                        BOOK NOW
                                    </a>
                                    <a href="{{ route('services.show', $svc->id) }}" class="btn-pro btn-pro-outline py-3 px-3 fs-9 bg-black bg-opacity-50">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
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
        <!-- Existing Stats -->
        @if($site_settings->stats_1_value)
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">{{ $site_settings->stats_1_value }}</span>
            <span class="section-tag opacity-40">{{ $site_settings->stats_1_label }}</span>
        </div>
        @endif
        @if($site_settings->stats_2_value)
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">{{ $site_settings->stats_2_value }}</span>
            <span class="section-tag opacity-40">{{ $site_settings->stats_2_label }}</span>
        </div>
        @endif
        @if($site_settings->stats_3_value)
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">{{ $site_settings->stats_3_value }}</span>
            <span class="section-tag opacity-40">{{ $site_settings->stats_3_label }}</span>
        </div>
        @endif
        @if($site_settings->stats_4_value)
        <div class="stat-item-pro">
            <span class="d-block display-5 fw-900 text-primary mb-2">{{ $site_settings->stats_4_value }}</span>
            <span class="section-tag opacity-40">{{ $site_settings->stats_4_label }}</span>
        </div>
        @endif
    </section>

    <!-- ... (Quick Book & Lead Capture remain) ... -->

    <!-- SECTION: SPLIT SHOWCASE -->
    <section class="section-padding p-0 bg-body">
        <div class="row g-0">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="service-img-wrapper h-100" style="min-height: 600px;">
                    <img src="{{ filter_var($site_settings->showcase_image, FILTER_VALIDATE_URL) ? $site_settings->showcase_image : asset('storage/' . $site_settings->showcase_image) }}" class="reveal h-100 w-100 object-fit-cover" alt="Performance" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&q=80&w=2000'">
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center p-5 p-lg-12 bg-surface order-1 order-lg-2">
                <div class="reveal">
                    <span class="section-tag mb-4" style="color: var(--db-accent);">THE STANDARD</span>
                    <h2 class="display-3 ls-narrower mb-4">{!! nl2br($site_settings->showcase_title ?? 'ENGINEERED<br>PRECISION_') !!}</h2>
                    <p class="fs-6 opacity-50 mb-5" style="line-height: 2;">
                        {{ $site_settings->showcase_description ?? "Drive Boosted operates at the intersection of high-performance chemical engineering and artisanal automotive care. We don't just detail; we preserve, protect, and perfect every micron of your vehicle's surface." }}
                    </p>
                    
                    @if($site_settings->showcase_btn_text)
                    <a href="{{ $site_settings->showcase_btn_link ?? '#' }}" class="btn-pro btn-pro-primary px-5 py-4">{{ $site_settings->showcase_btn_text }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: QUICK BOOK -->
    <section class="section-padding bg-black border-bottom border-white border-opacity-5 position-relative overflow-hidden">
        <div class="hero-bg opacity-20" style="background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=2000'); background-attachment: fixed;"></div>
        <div class="nav-container position-relative z-2">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0 reveal">
                    <span class="section-tag mb-3" style="color: var(--db-accent);">INSTANT_PROTOCOL</span>
                    <h2 class="display-3 ls-narrower m-0 mb-4">QUICK <span class="text-accent">BOOKING.</span></h2>
                    <p class="fs-6 opacity-60 mb-5">Secure your slot in our laboratory instantly. Our specialists will confirm your vehicle's admission protocol within 1 hour.</p>
                    <div class="d-flex gap-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-1 text-accent"><i class="fas fa-bolt"></i></div>
                            <div>
                                <span class="d-block fs-10 fw-bold uppercase ls-2 opacity-50">Response Time</span>
                                <span class="fs-6 fw-bold text-white">Under 60 Mins</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1 reveal">
                    <div class="bg-surface border border-white border-opacity-10 p-5 p-lg-12 position-relative">
                        <div class="aura-glow" style="opacity: 0.5;"></div>
                        <form action="{{ route('appointment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="source" value="quick_book">
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="fs-10 fw-bold uppercase ls-2 text-accent mb-2">Your Name</label>
                                    <input type="text" name="customer_name" class="form-control bg-body border-white border-opacity-10 text-white rounded-0 px-4 py-3" placeholder="FULL NAME" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-10 fw-bold uppercase ls-2 text-accent mb-2">Phone Number</label>
                                    <input type="tel" name="customer_phone" class="form-control bg-body border-white border-opacity-10 text-white rounded-0 px-4 py-3" placeholder="01XXXXXXXXX" autocomplete="tel" required>
                                </div>
                            </div>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="fs-10 fw-bold uppercase ls-2 text-accent mb-2">Vehicle Model</label>
                                    <input type="text" name="vehicle_model" class="form-control bg-body border-white border-opacity-10 text-white rounded-0 px-4 py-3" placeholder="e.g. TOYOTA PREMIO" required>
                                </div>
                                <div class="col-md-6">
                                <label class="fs-10 fw-bold uppercase ls-2 text-accent mb-2">Date</label>
                                    <input type="date" name="appointment_date" class="form-control bg-body border-white border-opacity-10 text-white rounded-0 px-4 py-3" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="fs-10 fw-bold uppercase ls-2 text-accent mb-2">Preferred Service</label>
                                <select name="service_ids[]" class="form-control bg-body border-white border-opacity-10 text-white rounded-0 px-4 py-3" required>
                                    <option value="" disabled selected>SELECT PROTOCOL...</option>
                                    @foreach($services as $svc)
                                        <option value="{{ $svc->id }}">{{ $svc->name }} (Starts ৳{{ number_format($svc->price) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn-pro btn-pro-primary w-100 py-3">CONFIRM REQUEST <i class="fas fa-arrow-right ms-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LEAD CAPTURE MODAL -->
    <div class="modal fade" id="leadCaptureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-surface border border-accent rounded-0 p-0 overflow-hidden">
                <div class="position-absolute top-0 end-0 p-3 z-3">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row g-0">
                    <div class="col-5 d-none d-md-block">
                        <img src="{{ asset('images/hero.png') }}" class="w-100 h-100 object-fit-cover" alt="Exclusive Offer">
                    </div>
                    <div class="col-md-7 p-5 p-lg-12 d-flex flex-column justify-content-center">
                        <span class="fs-10 fw-bold uppercase ls-2 text-accent mb-2">DRIVE BOOSTED EXCLUSIVE</span>
                        <h3 class="display-6 fw-bold text-white mb-3">UNLOCK VIP OFFERS_</h3>
                        <p class="fs-9 opacity-70 mb-4">Join our elite list to receive priority booking status and exclusive seasonal discounts on Ceramic Coatings.</p>
                        
                        <form id="leadCaptureForm">
                            @csrf
                            <input type="tel" name="phone" class="form-control bg-body border-white border-opacity-10 text-white rounded-0 px-4 py-3 mb-3" placeholder="ENTER PHONE NUMBER" autocomplete="tel" required>
                            <button type="submit" class="btn-pro btn-pro-primary w-100 py-3">GET ACCESS <i class="fas fa-lock-open ms-2"></i></button>
                        </form>
                        <div id="leadSuccessMsg" class="d-none mt-3 text-accent fs-9 fw-bold text-center">
                            <i class="fas fa-check-circle me-1"></i> YOU ARE ON THE LIST.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
        // Swiper Init
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

        // Lead Capture Logic
        const leadModal = new bootstrap.Modal(document.getElementById('leadCaptureModal'));
        const hasSeenModal = localStorage.getItem('db_lead_captured');

        if (!hasSeenModal) {
            setTimeout(() => {
                leadModal.show();
            }, 5000); // Show after 5 seconds
        }

        document.getElementById('leadCaptureForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = form.querySelector('button');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> PROCESSING...';
            btn.disabled = true;

            const formData = new FormData(form);

            fetch('{{ route("leads.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    form.style.display = 'none';
                    document.getElementById('leadSuccessMsg').classList.remove('d-none');
                    localStorage.setItem('db_lead_captured', 'true');
                    setTimeout(() => {
                        leadModal.hide();
                    }, 2000);
                } else {
                    alert(data.message || 'Error occurred');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    });
</script>
@endpush
