@extends('layouts.app')

@section('title', 'Secure Checkout | Drive Boosted')

@push('styles')
<style>
    /* Checkout Premium Overhaul */
    .checkout-page {
        padding-top: 150px;
        background: var(--db-bg-body);
    }

    .checkout-form-card {
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 60px;
        border-radius: var(--db-radius);
    }

    @media (max-width: 768px) {
        .checkout-form-card {
            padding: 30px;
            border: none;
            background: transparent;
        }
    }

    .checkout-section-title {
        font-size: 0.8rem;
        font-weight: 950;
        color: var(--db-accent);
        letter-spacing: 0.25em;
        text-transform: uppercase;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .checkout-section-title::after {
        content: '';
        flex-grow: 1;
        height: 1px;
        background: var(--db-border-subtle);
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 25px;
        background: var(--db-bg-body);
        border: 1px solid var(--db-border-strong);
        cursor: pointer;
        transition: var(--db-transition);
        margin-bottom: 1rem;
        border-radius: var(--db-radius);
    }

    .payment-option:hover {
        border-color: var(--db-accent-glow);
    }

    .payment-option.active {
        border-color: var(--db-accent);
        background: rgba(var(--db-accent-rgb), 0.05);
    }

    .payment-option input {
        display: none;
    }

    .payment-option.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .order-summary-box {
        position: sticky;
        top: calc(var(--db-nav-height) + 40px);
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 40px;
        border-radius: var(--db-radius);
    }

    .checkout-item {
        display: flex;
        gap: 20px;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--db-border-subtle);
    }

    .checkout-item img {
        width: 70px;
        height: 70px;
        background: var(--db-bg-elevated);
        border: 1px solid var(--db-border-subtle);
        padding: 8px;
        object-fit: contain;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
    <main class="checkout-page pb-10">
        <div class="nav-container">
            <div class="row g-6">
                <!-- Main Form -->
                <div class="col-lg-7 reveal">
                    <div class="checkout-form-card">
                        <div class="mb-10">
                            <span class="section-tag mb-3 d-block" style="color: var(--db-accent);">SECURE_TRANSACTION</span>
                            <h1 class="display-4 ls-narrower m-0">FINAL_CHECKOUT</h1>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-glass border-danger bg-danger bg-opacity-10 text-danger p-4 mb-10 rounded-0 fs-9 fw-900 ls-1">
                                <ul class="mb-0 list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('order.store') }}" method="POST">
                            @csrf
                            
                            <!-- Destination Protocol -->
                            <div class="checkout-section-title">01 / DESTINATION_INFO</div>
                            <div class="row g-4 mb-10">
                                <div class="col-12">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Consignee Full Name</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="YOUR FULL NAME" value="{{ old('customer_name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Secure Email Address</label>
                                    <input type="email" name="customer_email" class="form-control" placeholder="EMAIL@EXAMPLE.COM" value="{{ old('customer_email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Encryption-enabled Phone</label>
                                    <input type="tel" name="customer_phone" class="form-control" placeholder="+880" value="{{ old('customer_phone') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Primary Logistics Address</label>
                                    <textarea name="customer_address" class="form-control" rows="3" placeholder="FULL STREET ADDRESS, APARTMENT, ETC." required>{{ old('customer_address') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Sector / City</label>
                                    <input type="text" name="customer_city" class="form-control" placeholder="DHAKA" value="{{ old('customer_city', 'Dhaka') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Postal Zone Code</label>
                                    <input type="text" name="customer_postal_code" class="form-control" value="{{ old('customer_postal_code') }}" placeholder="1212">
                                </div>
                            </div>

                            <!-- Payment Protocol -->
                            <div class="checkout-section-title">02 / PAYMENT_METHOD</div>
                            <div class="payment-selection-box mb-10">
                                <label class="payment-option active" id="cod-label">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked id="cod">
                                    <div class="d-flex align-items-center gap-4">
                                        <i class="fas fa-hand-holding-usd fs-3 opacity-30"></i>
                                        <div>
                                            <span class="d-block fs-8 fw-950 ls-2 uppercase">Cash on Delivery (COD)</span>
                                            <span class="fs-10 opacity-40 uppercase ls-1">Settle account upon asset arrival</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option disabled">
                                    <input type="radio" name="payment_method" value="online" disabled id="online">
                                    <div class="d-flex align-items-center gap-4">
                                        <i class="fas fa-shield-alt fs-3 opacity-30"></i>
                                        <div>
                                            <span class="d-block fs-8 fw-950 ls-2 uppercase">Online Encryption [DISABLED]</span>
                                            <span class="fs-10 opacity-40 uppercase ls-1">Maintenance in progress</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <button type="submit" class="btn-pro btn-pro-primary w-100 py-4 mt-5 fs-8">FINALIZE_TRANSACTION <i class="fas fa-lock ms-2"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="order-summary-box reveal" style="transition-delay: 0.2s;">
                        <h3 class="fs-7 fw-950 ls-3 mb-8 uppercase border-bottom border-white border-opacity-5 pb-4">MANIFEST_DETAILS</h3>
                        
                        <div class="checkout-items mb-8">
                            @foreach(session('cart', []) as $id => $details)
                            <div class="checkout-item">
                                <div class="position-relative shrink-0">
                                    <img src="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset('storage/' . $details['image']) }}?auto=format&q=80&w=100" 
                                         alt="{{ $details['name'] }}"
                                         onerror="this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-accent text-white fw-900 border border-white border-opacity-10" style="font-size: 0.6rem; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                        {{ $details['quantity'] }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-9 fw-950 uppercase ls-1 mb-2">{{ $details['name'] }}</h5>
                                    <span class="fs-10 opacity-60">৳{{ number_format($details['price']) }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fs-9 fw-900 text-white">৳{{ number_format($details['price'] * $details['quantity']) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-top border-white border-opacity-5 pt-6">
                            <div class="d-flex justify-content-between mb-3 fs-9">
                                <span class="opacity-60 uppercase ls-1">Subtotal</span>
                                <span class="fw-900">৳{{ number_format($subtotal ?? 0) }}</span>
                            </div>
                            @if(isset($discount) && $discount > 0)
                            <div class="d-flex justify-content-between mb-3 fs-9 text-accent">
                                <span class="uppercase ls-1">Discount</span>
                                <span class="fw-900">-৳{{ number_format($discount) }}</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between mb-6 fs-9">
                                <span class="opacity-60 uppercase ls-1">Shipping</span>
                                <span class="fw-900 uppercase ls-1 text-accent">Complimentary</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-6 fw-950 uppercase ls-1">Total Due</span>
                                <span class="display-6 fw-950 text-white">৳{{ number_format($total ?? 0) }}</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-top border-white border-opacity-5 text-center">
                             <span class="fs-11 opacity-30 uppercase ls-2 d-block mb-3">Guaranteed Safe Checkout</span>
                             <div class="d-flex justify-content-center gap-3 opacity-30">
                                <i class="fab fa-cc-visa fa-lg"></i>
                                <i class="fab fa-cc-mastercard fa-lg"></i>
                                <i class="fab fa-cc-amex fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

    .checkout-form-card {
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 60px;
    }

    @media (max-width: 768px) {
        .checkout-form-card {
            padding: 30px;
        }
    }

    .checkout-section-title {
        font-size: 0.8rem;
        font-weight: 950;
        color: var(--db-accent);
        letter-spacing: 0.25em;
        text-transform: uppercase;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .checkout-section-title::after {
        content: '';
        flex-grow: 1;
        height: 1px;
        background: var(--db-border-subtle);
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 25px;
        background: var(--db-bg-body);
        border: 1px solid var(--db-border-strong);
        cursor: pointer;
        transition: var(--db-transition);
        margin-bottom: 1rem;
    }

    .payment-option:hover {
        border-color: var(--db-accent-glow);
    }

    .payment-option.active {
        border-color: var(--db-accent);
        background: var(--db-accent-glow);
    }

    .payment-option input {
        display: none;
    }

    .payment-option.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .order-summary-box {
        position: sticky;
        top: calc(var(--db-nav-height) + 40px);
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 40px;
    }

    .checkout-item {
        display: flex;
        gap: 15px;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--db-border-subtle);
    }

    .checkout-item img {
        width: 60px;
        height: 60px;
        background: var(--db-bg-body);
        border: 1px solid var(--db-border-subtle);
        padding: 8px;
        object-fit: contain;
    }
</style>
@endpush

@section('content')
    <main class="checkout-page pb-10">
        <div class="nav-container">
            <div class="row g-6">
                <!-- Main Form -->
                <div class="col-lg-7 reveal">
                    <div class="checkout-form-card">
                        <div class="mb-10">
                            <span class="section-tag mb-3" style="color: var(--db-accent);">SECURE_TRANSACTION</span>
                            <h1 class="display-4 ls-narrower m-0">FINAL_CHECKOUT</h1>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-glass border-danger bg-danger bg-opacity-10 text-danger p-4 mb-10 rounded-0 fs-9 fw-900 ls-1">
                                <ul class="mb-0 list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('order.store') }}" method="POST">
                            @csrf
                            
                            <!-- Destination Protocol -->
                            <div class="checkout-section-title">01 / DESTINATION_INFO</div>
                            <div class="row g-4 mb-10">
                                <div class="col-12">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Consignee Full Name</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="YOUR FULL NAME" value="{{ old('customer_name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Secure Email Address</label>
                                    <input type="email" name="customer_email" class="form-control" placeholder="EMAIL@EXAMPLE.COM" value="{{ old('customer_email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Encryption-enabled Phone</label>
                                    <input type="tel" name="customer_phone" class="form-control" placeholder="+880" value="{{ old('customer_phone') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Primary Logistics Address</label>
                                    <textarea name="customer_address" class="form-control" rows="3" placeholder="FULL STREET ADDRESS, APARTMENT, ETC." required>{{ old('customer_address') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Sector / City</label>
                                    <input type="text" name="customer_city" class="form-control" placeholder="DHAKA" value="{{ old('customer_city', 'Dhaka') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-11 fw-950 opacity-30 ls-2 uppercase d-block mb-3">Postal Zone Code</label>
                                    <input type="text" name="customer_postal_code" class="form-control" value="{{ old('customer_postal_code') }}" placeholder="1212">
                                </div>
                            </div>

                            <!-- Payment Protocol -->
                            <div class="checkout-section-title">02 / PAYMENT_METHOD</div>
                            <div class="payment-selection-box mb-10">
                                <label class="payment-option active" id="cod-label">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked id="cod">
                                    <div class="d-flex align-items-center gap-4">
                                        <i class="fas fa-hand-holding-usd fs-3 opacity-30"></i>
                                        <div>
                                            <span class="d-block fs-8 fw-950 ls-2 uppercase">Cash on Delivery (COD)</span>
                                            <span class="fs-10 opacity-40 uppercase ls-1">Settle account upon asset arrival</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option disabled">
                                    <input type="radio" name="payment_method" value="online" disabled id="online">
                                    <div class="d-flex align-items-center gap-4">
                                        <i class="fas fa-shield-alt fs-3 opacity-30"></i>
                                        <div>
                                            <span class="d-block fs-8 fw-950 ls-2 uppercase">Online Encryption [DISABLED]</span>
                                            <span class="fs-10 opacity-40 uppercase ls-1">Maintenance in progress</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <button type="submit" class="btn-pro btn-pro-primary w-100 py-4 mt-5 fs-8">FINALIZE_TRANSACTION <i class="fas fa-lock ms-2"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="order-summary-box reveal" style="transition-delay: 0.2s;">
                        <h3 class="fs-7 fw-950 ls-3 mb-8 uppercase">MANIFEST_DETAILS</h3>
                        
                        <div class="checkout-items mb-8">
                            @foreach(session('cart', []) as $id => $details)
                            <div class="checkout-item">
                                <div class="position-relative">
                                    <img src="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset('storage/' . $details['image']) }}?auto=format&q=80&w=100" 
                                         alt="{{ $details['name'] }}"
                                         onerror="this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-accent text-white fw-900 border border-white border-opacity-10" style="font-size: 0.6rem; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                        {{ $details['quantity'] }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fs-11 fw-950 opacity-30 ls-2 d-block mb-1 uppercase">GEAR_ID: {{ strtoupper(Str::limit($id, 6, '')) }}</span>
                                    <h4 class="fs-9 fw-900 m-0 mb-1">{{ $details['name'] }}</h4>
                                    <span class="fs-9 opacity-50 fw-900">৳{{ number_format($details['price']) }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fs-8 fw-950">৳{{ number_format($details['price'] * $details['quantity']) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="summary-rows pt-4">
                            <div class="summary-row mb-3">
                                <span class="opacity-40 uppercase ls-1 fs-10">SUBTOTAL</span>
                                <span class="fw-900">৳{{ number_format($subtotal) }}</span>
                            </div>
                            <div class="summary-row mb-3">
                                <span class="opacity-40 uppercase ls-1 fs-10">LOGISTICS_FEES</span>
                                <span class="text-accent fw-900 fs-10 ls-2 uppercase">FREE</span>
                            </div>
                            @if($discount > 0)
                            <div class="summary-row mb-3 text-accent">
                                <span class="uppercase ls-1 fs-10">DISCOUNT_PROTO</span>
                                <span class="fw-900">-৳{{ number_format($discount) }}</span>
                            </div>
                            @endif
                            <div class="summary-total mt-6 border-top border-white border-opacity-10 pt-6">
                                <span class="fs-9 fw-950 opacity-40 ls-2 uppercase">TOTAL_ASSETS</span>
                                <span class="fs-3 fw-950 text-accent">৳{{ number_format($total) }}</span>
                            </div>
                        </div>

                        <div class="mt-8 p-4 bg-surface border border-white border-opacity-5 text-center">
                            <p class="fs-11 opacity-30 ls-1 m-0">ALL TRANSACTIONS ARE PROTECTED BY DRIVE BOOSTED SECURITY PROTOCOLS.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
