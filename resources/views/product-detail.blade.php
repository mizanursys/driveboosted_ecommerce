@extends('layouts.app')

@section('title', $product->name . ' | Drive Boosted Elite Detailing')

@push('styles')
<style>
    /* Product Detail Premium Overhaul */
    .product-page-pro {
        padding-top: 150px;
        background: var(--db-bg-body);
    }

    .gallery-container {
        position: sticky;
        top: calc(var(--db-nav-height) + 40px);
    }

    .gallery-main {
        background: var(--db-bg-surface);
        border: var(--db-glass-border);
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border-radius: var(--db-radius);
    }

    .gallery-main::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, var(--db-accent-glow), transparent 70%);
        opacity: 0.15;
    }

    .gallery-main img {
        max-height: 500px;
        width: 100%;
        object-fit: contain;
        transition: var(--db-transition);
        z-index: 2;
    }

    .gallery-main:hover img {
        transform: scale(1.02);
    }

    /* Meta Block */
    .product-meta-block {
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--db-border-subtle);
        margin-bottom: 3rem;
    }

    /* Quantity & Action Engine */
    .quantity-selector {
        display: flex;
        align-items: center;
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-strong);
        width: fit-content;
        height: 60px;
        border-radius: var(--db-radius);
    }

    .qty-btn {
        width: 50px;
        height: 100%;
        border: 0;
        background: transparent;
        color: var(--db-text-primary);
        font-family: var(--db-font-heading);
        font-weight: 900;
        transition: var(--db-transition);
        cursor: pointer;
    }

    .qty-btn:hover {
        color: var(--db-accent);
        background: var(--db-bg-elevated);
    }

    .qty-input {
        width: 60px;
        height: 100%;
        border: 0;
        background: transparent;
        color: var(--db-text-primary);
        text-align: center;
        font-family: var(--db-font-heading);
        font-weight: 950;
        font-size: 1.2rem;
        border-left: 1px solid var(--db-border-subtle);
        border-right: 1px solid var(--db-border-subtle);
    }

    .qty-input:focus {
        outline: none;
        background: var(--db-bg-elevated);
    }

    /* Accordion Redesign */
    .db-accordion .accordion-item {
        background: transparent;
        border: 0;
        border-bottom: 1px solid var(--db-border-subtle);
    }

    .db-accordion .accordion-button {
        background: transparent;
        color: var(--db-text-primary);
        padding: 1.5rem 0;
        font-family: var(--db-font-heading);
        font-weight: 950;
        font-size: 0.8rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        box-shadow: none;
    }

    .db-accordion .accordion-button:not(.collapsed) {
        color: var(--db-accent);
    }

    .db-accordion .accordion-button::after {
        filter: invert(1) brightness(2);
        background-size: 0.8rem;
    }

    .db-accordion .accordion-body {
        padding: 0 0 2rem 0;
        font-size: 0.9rem;
        line-height: 1.8;
        opacity: 0.7;
        color: var(--db-text-secondary);
    }

    /* Feature List */
    .feature-list li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .feature-list i {
        color: var(--db-accent);
        width: 20px;
        text-align: center;
    }
</style>
@endpush

@section('content')
    <main class="product-page-pro pb-10">
        <div class="nav-container">
            <!-- Breadcrumbs -->
            <nav class="mb-5 reveal">
                <a href="{{ url('/catalog') }}" class="nav-link-rsa p-0 fs-10 opacity-40 hover-opacity-100">SHOWROOM</a>
                <span class="mx-3 opacity-10">/</span>
                <a href="{{ url('/catalog?category=' . $product->category->slug) }}" class="nav-link-rsa p-0 fs-10 opacity-40 hover-opacity-100 uppercase">{{ $product->category->name }}</a>
                <span class="mx-3 opacity-10">/</span>
                <span class="fs-10 fw-950 ls-2 uppercase text-accent">{{ $product->sku ?? 'ITEM_' . $product->id }}</span>
            </nav>

            <div class="row g-6">
                <!-- Gallery Section -->
                <div class="col-lg-7">
                    <div class="gallery-container reveal">
                        <div class="gallery-main mb-4">
                            <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}?auto=format&q=90&w=1200" 
                                 alt="{{ $product->name }}" 
                                 id="mainProductImage"
                                 onerror="this.onerror=null;this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                        </div>
                        <div class="d-flex gap-3 justify-content-center opacity-40">
                            <i class="fas fa-search-plus"></i>
                            <span class="fs-10 ls-2 uppercase">High Resolution Inspect</span>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="col-lg-5">
                    <div class="product-info-panel reveal" style="transition-delay: 0.2s;">
                        <div class="product-meta-block">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <span class="section-tag d-block" style="color: var(--db-accent);">LAB_EQUIPMENT</span>
                                <!-- Stock Indicator -->
                                <div class="badge-pro {{ $product->stock_quantity > 0 ? 'bg-white text-black' : 'bg-accent text-white' }} px-3 py-1 fs-11 fw-900 ls-1 uppercase">
                                    {{ $product->stock_quantity > 0 ? 'In Stock' : 'Sold Out' }}
                                </div>
                            </div>
                            
                            <h1 class="display-4 ls-narrower m-0 mb-4 lh-sm">{{ $product->name }}</h1>
                            
                            <div class="d-flex align-items-center gap-4">
                                <span class="display-6 fw-900 text-white">৳{{ number_format($product->price) }}</span>
                                <span class="fs-9 opacity-40 uppercase ls-1">Tax Included</span>
                            </div>
                        </div>

                        <div class="description-block mb-6">
                            <p class="fs-6 opacity-70" style="line-height: 1.8;">{{ $product->description }}</p>
                        </div>

                        <!-- Purchase Interface -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-cart-form mb-6">
                            @csrf
                            <div class="d-flex gap-4">
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn" onclick="this.nextElementSibling.stepDown()">-</button>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity ?? 99 }}" class="qty-input">
                                    <button type="button" class="qty-btn" onclick="this.previousElementSibling.stepUp()">+</button>
                                </div>
                                <button type="submit" class="btn-pro btn-pro-primary flex-grow-1 py-0 fs-8 fw-950 ls-2" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                                    {{ $product->stock_quantity > 0 ? 'ADD TO REGISTRY' : 'UNAVAILABLE' }}
                                </button>
                            </div>
                        </form>

                        <!-- Specifications Accordion -->
                        <div class="db-accordion accordion" id="specAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#spec1">
                                        Chemical Engineering
                                    </button>
                                </h2>
                                <div id="spec1" class="accordion-collapse collapse show" data-bs-parent="#specAccordion">
                                    <div class="accordion-body">
                                        Drive Boosted formulations utilize advanced molecular stabilizers to ensure consistent performance across varying thermal environments. Designed for professional endurance.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spec2">
                                        Application Directive
                                    </button>
                                </h2>
                                <div id="spec2" class="accordion-collapse collapse" data-bs-parent="#specAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled feature-list m-0">
                                            <li><i class="fas fa-check"></i> <span>Ensure surface is decontaminated.</span></li>
                                            <li><i class="fas fa-check"></i> <span>Apply in shaded, cool environment.</span></li>
                                            <li><i class="fas fa-check"></i> <span>Allow cure time of 20 minutes.</span></li>
                                            <li><i class="fas fa-check"></i> <span>Buff with plush microfiber.</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#spec3">
                                        Safety Data
                                    </button>
                                </h2>
                                <div id="spec3" class="accordion-collapse collapse" data-bs-parent="#specAccordion">
                                    <div class="accordion-body">
                                        Avoid eye contact. Use in ventilated area. Keep out of reach of children. Formula optimized for minimal volatile organic compounds (VOCs).
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION: Car Services -->
        @if($services->isNotEmpty())
        <div class="nav-container mt-6">
            <div class="row align-items-end mb-5">
                <div class="col-lg-8">
                    <span class="section-tag mb-3" style="color: var(--db-accent);">PROFESSIONAL SERVICES</span>
                    <h2 class="display-4 ls-narrower m-0">BOOK A SERVICE_</h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('services.index') }}" class="btn-pro btn-pro-outline py-3 px-5 fs-9">VIEW ALL SERVICES</a>
                </div>
            </div>
            
            <div class="row g-4">
                @foreach($services as $service)
                <div class="col-lg-4">
                    <div class="service-card-modern">
                        <div class="service-img-wrapper">
                            <img src="{{ $service->image }}?auto=format&fit=crop&q=80&w=1000" alt="{{ $service->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&q=80&w=1000'">
                        </div>
                        <div class="p-5 flex-grow-1 d-flex flex-column">
                            <span class="fs-10 fw-950 text-accent ls-3 uppercase mb-2">Starts From ৳{{ number_format($service->price) }}</span>
                            <h3 class="fs-4 mb-4">{{ $service->name }}</h3>
                            <p class="fs-7 opacity-50 mb-5 flex-grow-1">{{ Str::limit($service->description, 100) }}</p>
                            <a href="{{ route('appointment.create', ['service' => $service->id]) }}" class="btn-pro btn-pro-primary w-100 py-3 fs-9">BOOK NOW</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- SECTION: Featured/Best-Selling Products -->
        @if($featuredProducts->isNotEmpty())
        <div class="nav-container mt-6">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <span class="section-tag mb-3" style="color: var(--db-accent);">FEATURED GEAR</span>
                    <h2 class="display-4 ls-narrower m-0">BEST SELLERS_</h2>
                </div>
                <a href="{{ url('/catalog') }}" class="nav-link-rsa p-0 border-bottom border-accent">BROWSE ALL →</a>
            </div>

            <div class="product-grid">
                @foreach($featuredProducts as $featuredProduct)
                <div class="product-card-rsa group-hover-trigger">
                    <div class="sale-badge">FEATURED</div>
                    <a href="{{ route('product.show', $featuredProduct->slug) }}" class="rsa-card-image d-block">
                        <img src="{{ filter_var($featuredProduct->image, FILTER_VALIDATE_URL) ? $featuredProduct->image : asset('storage/' . $featuredProduct->image) }}?auto=format&q=80&w=600" alt="{{ $featuredProduct->name }}" onerror="this.onerror=null;this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                    </a>
                    <div class="rsa-card-body">
                        <h3 class="rsa-card-title">{{ $featuredProduct->name }}</h3>
                        <div class="rsa-card-price">
                            <span class="price-current">৳{{ number_format($featuredProduct->price) }}</span>
                        </div>
                        <form action="{{ route('cart.add', $featuredProduct->id) }}" method="POST" class="ajax-cart-form m-0 mt-auto">
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
        @endif
    </main>
@endsection

