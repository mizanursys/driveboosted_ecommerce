@extends('layouts.app')

@section('title', 'Order Logs | Drive Boosted')

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
                                <a href="#" class="d-block p-4 text-decoration-none fw-950 fs-9 ls-1 text-white opacity-40 hover-opacity-100">
                                    <i class="fas fa-cog me-3 w-5 text-center"></i> SETTINGS (WIP)
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
                        <div class="d-flex justify-content-between align-items-end mb-8">
                            <div>
                                <span class="section-tag mb-3 d-block" style="color: var(--db-accent);">ACQUISITION_LOGS</span>
                                <h1 class="display-5 fw-950 m-0 ls-narrower">ORDER HISTORY</h1>
                            </div>
                        </div>

                        @if($orders->count() > 0)
                            <div class="d-flex flex-column gap-3">
                                @foreach($orders as $order)
                                    <div class="p-5 border border-white border-opacity-5 bg-body rounded hover-border-accent transition-all">
                                        <div class="row align-items-center">
                                            <div class="col-md-3 mb-3 mb-md-0">
                                                <span class="fs-11 fw-950 opacity-40 ls-2 uppercase d-block mb-1">Sequence ID</span>
                                                <h3 class="fs-7 fw-900 text-white m-0 uppercase font-monospace">#{{ $order->order_number }}</h3>
                                            </div>
                                            <div class="col-md-3 mb-3 mb-md-0">
                                                <span class="fs-11 fw-950 opacity-40 ls-2 uppercase d-block mb-1">Timestamp</span>
                                                <p class="fs-9 text-white m-0 opacity-70">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <span class="fs-11 fw-950 opacity-40 ls-2 uppercase d-block mb-1">Valuation</span>
                                                <h3 class="fs-7 fw-900 text-white m-0">৳{{ number_format($order->total) }}</h3>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0 text-md-center">
                                                <span class="fs-11 fw-950 opacity-40 ls-2 uppercase d-block mb-1">Status</span>
                                                @php
                                                    $statusClass = match($order->status) {
                                                        'completed' => 'text-success',
                                                        'pending' => 'text-warning',
                                                        'cancelled' => 'text-danger',
                                                        default => 'text-primary'
                                                    };
                                                @endphp
                                                <span class="fw-950 uppercase ls-1 fs-10 {{ $statusClass }}">{{ $order->status }}</span>
                                            </div>
                                            <div class="col-md-2 text-md-end">
                                                <a href="{{ route('account.order.detail', $order->id) }}" class="btn-pro btn-pro-outline py-2 px-3 fs-10 border-opacity-20">INSPECT</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-8 d-flex justify-content-center">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="py-10 text-center border border-white border-opacity-5 rounded bg-body">
                                <i class="fas fa-box-open fs-2 opacity-10 mb-4 d-block"></i>
                                <span class="fs-9 opacity-40 uppercase ls-2 d-block mb-6">No acquisition logs found</span>
                                <a href="{{ route('catalog') }}" class="btn-pro btn-pro-primary px-4 py-3 fs-10">INITIATE ACQUISITION</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="account-nav bg-surface border border-white border-opacity-5 p-4 sticky-top" style="top: 120px;">
                        <h3 class="fs-9 fw-950 text-secondary opacity-40 ls-2 uppercase mb-4">Command Center</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ url('/account') }}" class="d-block p-3 text-decoration-none fw-900 fs-8 ls-1 {{ request()->is('account') ? 'bg-accent text-white' : 'text-primary' }}">DASHBOARD</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/account/orders') }}" class="d-block p-3 text-decoration-none fw-900 fs-8 ls-1 {{ request()->is('account/orders*') ? 'bg-accent text-white' : 'text-primary' }} hover-bg-surface transition-all">MY ORDERS</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/account/profile') }}" class="d-block p-3 text-decoration-none fw-900 fs-8 ls-1 {{ request()->is('account/profile') ? 'bg-accent text-white' : 'text-primary' }} hover-bg-surface transition-all">PROFILE SETTINGS</a>
                            </li>
                            <li class="mt-4 pt-4 border-top border-white border-opacity-5">
                                <a href="{{ url('/logout') }}" class="d-block p-3 text-decoration-none fw-900 fs-8 ls-1 text-danger hover-bg-surface transition-all">TERMINATE SESSION</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="bg-surface border border-white border-opacity-5 p-4 p-md-5 animate-fade-up">
                        <div class="d-flex justify-content-between align-items-end mb-5">
                            <div>
                                <span class="section-tag" style="color: var(--accent);">ORDER_LOGS</span>
                                <h1 class="display-5 fw-900 m-0 text-primary uppercase">ACQUISITION HISTORY</h1>
                            </div>
                        </div>

                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <div class="order-summary-item bg-elevated border border-white border-opacity-5 p-4 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Sequence ID</span>
                                            <h3 class="fs-7 fw-900 text-primary m-0 uppercase">#{{ $order->order_number }}</h3>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Timestamp</span>
                                            <p class="fs-8 text-secondary m-0">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Valuation</span>
                                            <h3 class="fs-7 fw-900 text-accent m-0">৳{{ number_format($order->total) }}</h3>
                                        </div>
                                        <div class="col-md-2 text-md-center">
                                            <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Status</span>
                                            @php
                                                $statusClass = $order->status == 'completed' ? 'text-success' : ($order->status == 'pending' ? 'text-warning' : 'text-primary');
                                            @endphp
                                            <span class="fw-950 uppercase ls-1 fs-9 {{ $statusClass }}">{{ $order->status }}</span>
                                        </div>
                                        <div class="col-md-2 text-md-end mt-3 mt-md-0">
                                            <a href="{{ url('/account/orders/' . $order->id) }}" class="btn-pro btn-pro-outline py-2 px-3 fs-9">VIEW_LOG</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-5 d-flex justify-content-center">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="py-5 text-center bg-elevated border border-white border-opacity-5">
                                <p class="text-secondary opacity-50 mb-4">No order sequences found in history.</p>
                                <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-primary px-4 py-3 fs-9">INITIATE ACQUISITION</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
