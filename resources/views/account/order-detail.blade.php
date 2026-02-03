@extends('layouts.app')

@section('title', 'Sequence Details | Drive Boosted')

@push('styles')
<style>
    .account-page-pro {
        padding-top: 150px;
        background: var(--db-bg-body);
        min-height: 100vh;
    }

    .account-nav {
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        border-radius: var(--db-radius);
        overflow: hidden;
    }
    
    .account-nav a {
        position: relative;
        transition: var(--db-transition);
        border-left: 2px solid transparent;
    }

    .account-nav a:hover, .account-nav a.active {
        background: rgba(255, 255, 255, 0.05);
        color: var(--db-accent) !important;
        border-left-color: var(--db-accent);
    }
</style>
@endpush

@section('content')
    <main class="account-page-pro pb-10">
        <div class="nav-container">
            <div class="row g-6">
                <!-- Sidebar -->
                <div class="col-lg-3 reveal">
                    <div class="account-nav sticky-top" style="top: 120px;">
                        <div class="p-5 border-bottom border-white border-opacity-5">
                            <span class="fs-11 fw-950 text-accent opacity-100 ls-2 uppercase d-block mb-2">Member ID</span>
                            <h3 class="fs-8 fw-900 text-white m-0 text-truncate">{{ auth()->user()->email }}</h3>
                        </div>
                        <ul class="list-unstyled m-0 p-0">
                            <li>
                                <a href="{{ route('account.dashboard') }}" class="d-block p-4 text-decoration-none fw-950 fs-9 ls-1 text-white {{ request()->routeIs('account.dashboard') ? 'active' : 'opacity-60' }}">
                                    <i class="fas fa-th-large me-3 w-5 text-center"></i> DASHBOARD
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('account.orders') }}" class="d-block p-4 text-decoration-none fw-950 fs-9 ls-1 text-white {{ request()->routeIs('account.orders*') ? 'active' : 'opacity-60' }}">
                                    <i class="fas fa-box me-3 w-5 text-center"></i> ORDER_HISTORY
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('account.profile') }}" class="d-block p-4 text-decoration-none fw-950 fs-9 ls-1 text-white {{ request()->routeIs('account.profile') ? 'active' : 'opacity-60' }}">
                                    <i class="fas fa-cog me-3 w-5 text-center"></i> PROFILE_SETTINGS
                                </a>
                            </li>
                            <li class="border-top border-white border-opacity-5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="d-block w-100 text-start p-4 bg-transparent border-0 text-decoration-none fw-950 fs-9 ls-1 text-danger hover-bg-surface">
                                        <i class="fas fa-power-off me-3 w-5 text-center"></i> TERMINATE_SESSION
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="glass-surface p-6 p-md-8 reveal" style="border-radius: var(--db-radius); transition-delay: 0.1s;">
                        <div class="mb-5">
                            <a href="{{ url('/account/orders') }}" class="text-decoration-none text-white opacity-50 hover-opacity-100 fs-10 fw-950 ls-2 uppercase"><i class="fas fa-long-arrow-alt-left me-2"></i> RETURN TO LOGS</a>
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-8 pb-6 border-bottom border-white border-opacity-5">
                            <div>
                                <span class="section-tag mb-3 d-block" style="color: var(--db-accent);">SEQUENCE_DETAILS</span>
                                <h1 class="display-5 fw-950 m-0 ls-narrower font-monospace text-uppercase">#{{ $order->order_number }}</h1>
                                <p class="fs-9 text-white m-0 opacity-60 mt-2">{{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('H:i') }} UTC</p>
                            </div>
                            <div class="text-end">
                                <span class="fs-11 fw-950 text-white opacity-40 ls-2 uppercase d-block mb-1">Current State</span>
                                @php
                                    $statusClass = match($order->status) {
                                        'completed' => 'text-success',
                                        'pending' => 'text-warning',
                                        'cancelled' => 'text-danger',
                                        default => 'text-primary'
                                    };
                                @endphp
                                <span class="fw-950 uppercase ls-2 fs-7 {{ $statusClass }}">{{ $order->status }}</span>

                                @if($order->status == 'completed' && $order->created_at->diffInDays(now()) < 30)
                                    <div class="mt-3">
                                        <button class="btn-pro btn-pro-outline py-2 px-3 fs-10 border-danger text-danger opacity-70 hover-opacity-100" onclick="alert('Please contact support@driveboosted.com with your Order ID for return processing.')">
                                            REQUEST RETURN
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row g-5 mb-8">
                            <div class="col-md-6">
                                <h3 class="fs-9 fw-950 text-white opacity-40 ls-3 uppercase mb-4">LOGISTICS INFO</h3>
                                <div class="bg-body p-5 border border-white border-opacity-5 fs-9 rounded">
                                    <p class="mb-1 text-white fw-900 uppercase ls-1">{{ $order->customer_name }}</p>
                                    <p class="mb-1 text-white opacity-60">{{ $order->customer_email }}</p>
                                    <p class="mb-1 text-white opacity-60">{{ $order->customer_phone }}</p>
                                    <p class="mb-0 text-white opacity-60 pt-2 border-top border-white border-opacity-5 mt-2">{{ $order->customer_address }}, {{ $order->customer_city }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3 class="fs-9 fw-950 text-white opacity-40 ls-3 uppercase mb-4">VALUATION</h3>
                                <div class="bg-body p-5 border border-white border-opacity-5 fs-9 rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-white opacity-50 uppercase ls-1">Subtotal</span>
                                        <span class="text-white fw-900">৳{{ number_format($order->subtotal) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-white opacity-50 uppercase ls-1">Logistics</span>
                                        <span class="text-accent fw-900 uppercase ls-1">Free</span>
                                    </div>
                                    <div class="d-flex justify-content-between pt-3 border-top border-white border-opacity-5 mt-2">
                                        <span class="text-white fw-950 uppercase ls-1">Total</span>
                                        <span class="text-accent fw-950 fs-5">৳{{ number_format($order->total) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="fs-9 fw-950 text-white opacity-40 ls-3 uppercase mb-4">ITEMIZED ACQUISITIONS</h3>
                        <div class="table-responsive">
                            <table class="table align-middle border-0" style="--bs-table-bg: transparent;">
                                <thead>
                                    <tr class="fs-10 text-white opacity-40 uppercase ls-2 border-bottom border-white border-opacity-5">
                                        <th class="py-3 ps-0 fw-950">Asset</th>
                                        <th class="py-3 fw-950">Unit Val</th>
                                        <th class="py-3 text-center fw-950">Qty</th>
                                        <th class="py-3 pe-0 text-end fw-950">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-9">
                                    @foreach($order->items as $item)
                                        <tr class="border-bottom border-white border-opacity-5">
                                            <td class="py-4 ps-0">
                                                <div class="d-flex align-items-center gap-4">
                                                    @php $img = $item->product ? $item->product->image : 'images/default-product.png'; @endphp
                                                    <img src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img) }}" 
                                                         class="bg-elevated p-1 border border-white border-opacity-10 rounded" 
                                                         style="width: 60px; height: 60px; object-fit: contain;"
                                                         onerror="this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
                                                    <div>
                                                        <span class="text-white fw-900 uppercase ls-1 d-block">{{ $item->product_name }}</span>
                                                        <span class="text-white opacity-40 fs-11 uppercase ls-1">SKU: {{ $item->product_id }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 text-white opacity-80">৳{{ number_format($item->price) }}</td>
                                            <td class="py-4 text-center text-white opacity-60 font-monospace">x{{ $item->quantity }}</td>
                                            <td class="py-4 pe-0 text-end text-accent fw-900">৳{{ number_format($item->subtotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($order->notes)
                            <div class="mt-8 p-5 bg-accent bg-opacity-5 border border-accent border-opacity-20 rounded">
                                <h4 class="fs-10 fw-950 text-accent ls-2 uppercase mb-3">COMMAND_NOTES</h4>
                                <p class="fs-9 text-white opacity-70 m-0 lh-lg">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

