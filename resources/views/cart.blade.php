@extends('layouts.app')

@section('title', 'Your Shopping Bag | Drive Boosted')

@push('styles')
<style>
    /* Cart Premium Overhaul */
    .cart-page {
        padding-top: 150px;
    }

    .cart-item-modern {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 2rem;
        padding: 2.5rem 0;
        border-bottom: 1px solid var(--db-border-subtle);
        align-items: center;
    }

    @media (max-width: 768px) {
        .cart-item-modern {
            grid-template-columns: 80px 1fr;
            gap: 1.5rem;
        }
        .cart-item-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--db-bg-surface);
            padding: 1rem;
            margin-top: 1rem;
        }
    }

    .cart-item-img {
        width: 120px;
        height: 120px;
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 15px;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .cart-item-img {
            width: 80px;
            height: 80px;
        }
    }

    .summary-sticky {
        position: sticky;
        top: calc(var(--db-nav-height) + 40px);
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 40px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
    }

    .summary-total {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--db-border-strong);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
</style>
@endpush

@section('content')
    <main class="cart-page pb-10">
        <div class="nav-container">
            <!-- Header -->
            <div class="mb-10 reveal">
                <span class="section-tag mb-3 d-block" style="color: var(--db-accent);">INVENTORY_CONTROL</span>
                <h1 class="display-3 ls-narrower m-0">YOUR GEAR_BAG</h1>
            </div>

            @if(session('cart') && count(session('cart')) > 0)
                <div class="row g-6">
                    <!-- Items List -->
                    <div class="col-lg-8 reveal">
                        <div class="glass-surface p-0" style="border-radius: var(--db-radius);">
                            <div class="cart-items-container">
                                @foreach(session('cart') as $id => $details)
                                <div class="cart-item-modern p-5 border-bottom border-white border-opacity-5">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-2">
                                            <img src="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset('storage/' . $details['image']) }}?auto=format&q=80&w=200" 
                                                 alt="{{ $details['name'] }}" 
                                                 class="cart-item-img w-100 object-fit-contain bg-surface p-2 border border-white border-opacity-5"
                                                 onerror="this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                                        </div>
                                        
                                        <div class="col-9 col-md-10">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <span class="fs-11 fw-950 opacity-30 ls-2 d-block mb-1 uppercase">GEAR_ID: {{ strtoupper(Str::limit($id, 8, '')) }}</span>
                                                    <h4 class="fs-6 fw-900 m-0 mb-2"><a href="{{ route('product.show', $details['slug'] ?? '') }}" class="text-decoration-none text-white">{{ $details['name'] }}</a></h4>
                                                    <span class="fs-9 text-accent fw-900">৳{{ number_format($details['price']) }}</span>
                                                </div>

                                                <div class="col-md-6 d-flex justify-content-between justify-content-md-end align-items-center gap-4">
                                                    <form action="{{ route('cart.update') }}" method="POST" class="quantity-selector" style="height: 40px;">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <button type="button" class="qty-btn fs-9" onclick="this.nextElementSibling.stepDown(); this.form.submit()">-</button>
                                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="qty-input fs-9" style="width: 40px;" readonly>
                                                        <button type="button" class="qty-btn fs-9" onclick="this.previousElementSibling.stepUp(); this.form.submit()">+</button>
                                                    </form>
                                                    
                                                    <div class="text-end d-none d-md-block" style="min-width: 100px;">
                                                        <span class="fs-6 fw-950">৳{{ number_format($details['price'] * $details['quantity']) }}</span>
                                                    </div>

                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <button type="submit" class="nav-icon opacity-30 hover-opacity-100 fs-9"><i class="fas fa-times"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-8 d-flex flex-column flex-md-row justify-content-between gap-4">
                            <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-outline px-5">RETURN TO SHOWROOM</a>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-pro text-danger opacity-50 hover-opacity-100 fs-10 fw-950 ls-2 uppercase bg-transparent border-0">ABANDON_SESSION [CLEAR]</button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="col-lg-4 reveal" style="transition-delay: 0.2s;">
                        <div class="summary-sticky p-5 border border-white border-opacity-5" style="border-radius: var(--db-radius);">
                            <h3 class="fs-7 fw-950 ls-3 mb-6 uppercase border-bottom border-white border-opacity-5 pb-4">MANIFEST_SUMMARY</h3>
                            
                            <div class="summary-row">
                                <span class="opacity-40">SUBTOTAL</span>
                                <span class="fw-900">৳{{ number_format($subtotal ?? 0) }}</span>
                            </div>

                            @if(isset($coupon))
                            <div class="summary-row text-accent">
                                <span>COUPON_APPLIED ({{ $coupon->code }})</span>
                                <span>-৳{{ number_format($discount ?? 0) }}</span>
                            </div>
                            @else
                            <form action="{{ route('cart.coupon') }}" method="POST" class="mb-6">
                                @csrf
                                <div class="d-flex border border-white border-opacity-5" style="border-radius: var(--db-radius); overflow: hidden;">
                                    <input type="text" name="code" class="form-control bg-transparent border-0 fs-9 ls-1 uppercase text-white" placeholder="ACCESS_CODE" style="box-shadow: none;">
                                    <button class="btn-pro btn-pro-outline border-0 py-3 px-4 fs-10" type="submit">APPLY</button>
                                </div>
                            </form>
                            @endif

                            <div class="summary-row">
                                <span class="opacity-40">LOGISTICS_FEES</span>
                                <span class="text-accent fw-900 fs-10 ls-2 uppercase">Complimentary</span>
                            </div>

                            <div class="summary-total">
                                <div class="text-start">
                                    <span class="fs-10 fw-950 opacity-30 ls-2 d-block uppercase">ESTIMATED_TOTAL</span>
                                    <span class="display-6 fw-950 text-white">৳{{ number_format($total ?? 0) }}</span>
                                </div>
                            </div>

                            <a href="{{ url('/checkout') }}" class="btn-pro btn-pro-primary w-100 py-4 mt-8 fs-8">INITIATE_CHECKOUT</a>
                            
                            <div class="mt-6 text-center opacity-30">
                                <i class="fas fa-lock fs-10 me-2"></i> <span class="fs-11 uppercase ls-1">Encrypted Transaction</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-20 text-center reveal glass-surface" style="border-radius: var(--db-radius);">
                    <i class="fas fa-shopping-bag fs-1 opacity-10 mb-5 d-block"></i>
                    <h2 class="display-5 fw-950 opacity-20 uppercase ls-4">Bag_Empty</h2>
                    <p class="fs-8 opacity-40 mt-3 ls-1">Your inventory registry is currently void of items.</p>
                    <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-primary mt-8 px-6">BROWSE SHOWROOM</a>
                </div>
            @endif
        </div>
    </main>
@endsection
