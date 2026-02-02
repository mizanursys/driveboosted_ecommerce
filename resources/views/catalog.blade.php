@extends('layouts.app')

@section('title', 'Showroom Catalog | Drive Boosted')

@push('styles')
<style>
    /* Catalog Specific Branding */
    .catalog-header {
        position: relative;
        padding-top: 150px;
        padding-bottom: 80px;
        background: var(--db-bg-body);
        overflow: hidden;
    }

    .catalog-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 70% 30%, var(--db-accent-glow), transparent 60%);
        opacity: 0.1;
    }

    @media (min-width: 992px) {
        .filter-sticky {
            position: sticky;
            top: calc(var(--db-nav-height) + 40px);
        }
    }

    .filter-group {
        margin-bottom: 3rem;
    }

    .filter-title {
        font-size: 0.7rem;
        font-weight: 950;
        color: var(--db-accent);
        letter-spacing: 0.2em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
        display: block;
        opacity: 0.4;
    }

    .filter-link {
        display: block;
        padding: 8px 0;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--db-text-secondary);
        text-decoration: none;
        transition: var(--db-transition);
        letter-spacing: 0.05em;
    }

    .filter-link:hover, .filter-link.active {
        color: var(--db-text-primary);
        padding-left: 5px;
    }

    .filter-link.active {
        border-left: 2px solid var(--db-accent);
        padding-left: 15px;
    }

    /* Product Grid Modernization */
    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1px;
        background: var(--db-border-subtle);
    }

    @media (min-width: 992px) {
        .catalog-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .catalog-item {
        background: var(--db-bg-body);
        transition: var(--db-transition);
        position: relative;
    }

    .catalog-item:hover {
        background: var(--db-bg-surface);
        z-index: 1;
        box-shadow: 0 0 40px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('content')
    <!-- SECTION: CATALOG HEADER -->
    <header class="catalog-header border-bottom border-white border-opacity-5">
        <div class="nav-container reveal">
            <div class="row align-items-end">
                <div class="col-lg-7">
                    <span class="section-tag mb-3" style="color: var(--db-accent);">GEAR_REGISTRY</span>
                    <h1 class="display-3 ls-narrower m-0">THE SHOWROOM_</h1>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <p class="fs-8 opacity-50 m-0 ls-1 uppercase">Supplying professional grade solutions for elite automotive care. Showing {{ $products->count() }} results.</p>
                </div>
            </div>
        </div>
    </header>

    <div class="nav-container py-5">
        <div class="row">
            <!-- Sidebar: Filters -->
            <aside class="col-lg-3">
                <div class="filter-sticky reveal p-4 glass-strong border-0" style="border-radius: var(--db-radius);">
                    <div class="filter-group">
                        <span class="fs-10 fw-950 opacity-40 ls-2 uppercase mb-4 d-block" style="color: var(--db-accent);">SECTORS / REGISTRY</span>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ url('/catalog') }}" class="nav-link-rsa {{ !request('category') ? 'active text-white' : '' }}" style="padding-left: 0;">
                                <i class="fas fa-caret-right me-2 opacity-{{ !request('category') ? '100 text-accent' : '0' }}"></i> ALL GEAR
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ url('/catalog?category=' . $cat->slug) }}" class="nav-link-rsa {{ request('category') == $cat->slug ? 'active text-white' : '' }}" style="padding-left: 0;">
                                    <i class="fas fa-caret-right me-2 opacity-{{ request('category') == $cat->slug ? '100 text-accent' : '0' }}"></i> {{ strtoupper($cat->name) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="filter-group pt-4 border-top border-white border-opacity-5">
                        <span class="fs-10 fw-950 opacity-40 ls-2 uppercase mb-4 d-block" style="color: var(--db-accent);">SORTING_PROTOCOL</span>
                        <div class="position-relative">
                            <select onchange="window.location.href=this.value" class="form-control bg-body border-0 fs-9 text-uppercase fw-800 ls-1">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => null]) }}">LATEST ARRIVALS</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>PRICE: LOW TO HIGH</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>PRICE: HIGH TO LOW</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>NAME: A-Z</option>
                            </select>
                            <i class="fas fa-sort position-absolute top-50 end-0 translate-middle-y me-3 opacity-50 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="filter-group mt-5 d-none d-lg-block">
                        <div class="p-4 bg-body border border-white border-opacity-5 text-center" style="border-radius: var(--db-radius);">
                            <i class="fas fa-shield-alt text-accent fs-4 mb-3 d-block"></i>
                            <span class="fs-10 fw-950 opacity-60 ls-2 uppercase d-block text-white">Drive Boosted Guarantee</span>
                            <span class="fs-11 opacity-40 ls-1 mt-2 d-block">AUTHENTIC_LAB_TESTED</span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main: Product Display -->
            <main class="col-lg-9">
                <div class="catalog-grid reveal">
                    @forelse($products as $idx => $product)
                    <div class="catalog-item" style="transition-delay: {{ ($idx % 3) * 0.1 }}s;">
                        <div class="product-card-pro bg-transparent border-0 h-100 d-flex flex-column group-hover-trigger">
                            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none h-100 d-flex flex-column">
                                <div class="card-img-wrapper">
                                    <div class="aura-glow"></div>
                                    <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}?auto=format&q=80&w=600" 
                                         alt="{{ $product->name }}"
                                         class="reveal-scale"
                                         onerror="this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                                </div>
                                
                                <div class="p-4 p-xl-5 mt-auto">
                                    <span class="fs-10 fw-950 text-accent opacity-50 ls-3 d-block mb-2 uppercase">{{ $product->category->name ?? 'GENERAL' }}</span>
                                    <h3 class="fs-8 fw-800 text-primary mb-4 uppercase ls-1" style="min-height: 2.5em; line-height: 1.4;">{{ $product->name }}</h3>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-950 fs-6 text-primary">৳{{ number_format($product->price) }}</span>
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-cart-form m-0">
                                            @csrf
                                            <button type="submit" class="bg-transparent border-0 text-accent p-0 hover-opacity-70 transition-all">
                                                <i class="fas fa-plus-square fa-xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-10 text-center bg-surface">
                        <i class="fas fa-box-open fs-1 opacity-10 mb-5 d-block"></i>
                        <h2 class="display-6 fw-950 opacity-20 uppercase ls-4">Empty_Registry</h2>
                        <p class="fs-9 opacity-40 mt-3 ls-1">No products found for the selected sector.</p>
                        <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-outline mt-5">RESET FILTERS</a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="py-5 d-flex justify-content-center border-top border-white border-opacity-5 mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @endif
            </main>
        </div>
    </div>
@endsection
