@extends('layouts.app')

@section('title', 'Command Center | Drive Boosted')

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

    .dashboard-stat-card {
        background: var(--db-bg-glass);
        border: 1px solid var(--db-border-subtle);
        padding: 1.5rem;
        height: 100%;
        transition: var(--db-transition);
        position: relative;
        overflow: hidden;
    }

    .dashboard-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top right, rgba(var(--db-accent-rgb), 0.1), transparent 60%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .dashboard-stat-card:hover {
        border-color: var(--db-accent-glow);
        transform: translateY(-2px);
    }

    .dashboard-stat-card:hover::before {
        opacity: 1;
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
                                <span class="section-tag mb-3 d-block" style="color: var(--db-accent);">COMMAND_CENTER</span>
                                <h1 class="display-5 fw-950 m-0 ls-narrower">WELCOME BACK, {{ explode(' ', auth()->user()->name)[0] }}</h1>
                            </div>
                        </div>

                        <div class="row g-4 mb-8">
                            <div class="col-md-4">
                                <div class="dashboard-stat-card">
                                    <span class="fs-11 fw-950 opacity-40 ls-2 uppercase d-block mb-3">Total Acquisitions</span>
                                    <h2 class="display-4 fw-900 text-white m-0 lh-1">{{ $totalOrders }}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-stat-card">
                                    <span class="fs-11 fw-950 text-warning opacity-80 ls-2 uppercase d-block mb-3">Active Sequences</span>
                                    <h2 class="display-4 fw-900 text-warning m-0 lh-1">{{ $pendingOrders }}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-stat-card">
                                    <span class="fs-11 fw-950 text-success opacity-80 ls-2 uppercase d-block mb-3">Completed</span>
                                    <h2 class="display-4 fw-900 text-success m-0 lh-1">{{ $completedOrders }}</h2>
                                </div>
                            </div>
                        </div>

                        <h3 class="fs-7 fw-950 ls-2 uppercase mb-6 border-bottom border-white border-opacity-5 pb-4">RECENT ACTIVITY_LOG</h3>
                        
                        @if($recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-middle border-0" style="--bs-table-bg: transparent;">
                                    <thead>
                                        <tr class="fs-11 text-white opacity-40 uppercase ls-2 border-bottom border-white border-opacity-5">
                                            <th class="py-3 ps-0 fw-950">Hash Ref</th>
                                            <th class="py-3 fw-950">Timestamp</th>
                                            <th class="py-3 fw-950">Valuation</th>
                                            <th class="py-3 fw-950">Status</th>
                                            <th class="py-3 pe-0 text-end fw-950">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-9">
                                        @foreach($recentOrders as $order)
                                            <tr class="border-bottom border-white border-opacity-5">
                                                <td class="py-4 ps-0 fw-950 text-accent">#{{ $order->order_number }}</td>
                                                <td class="py-4 opacity-70">{{ $order->created_at->format('M d, Y') }}</td>
                                                <td class="py-4 fw-900">৳{{ number_format($order->total) }}</td>
                                                <td class="py-4">
                                                    @php
                                                        $statusClass = match($order->status) {
                                                            'completed' => 'text-success',
                                                            'pending' => 'text-warning',
                                                            'cancelled' => 'text-danger',
                                                            default => 'text-primary'
                                                        };
                                                    @endphp
                                                    <span class="fw-950 uppercase ls-1 fs-11 {{ $statusClass }}">{{ $order->status }}</span>
                                                </td>
                                                <td class="py-4 pe-0 text-end">
                                                    <a href="{{ route('account.order.detail', $order->id) }}" class="btn-pro btn-pro-outline py-2 px-3 fs-10 border-opacity-20">INSPECT</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-10 text-center border border-white border-opacity-5 rounded bg-body">
                                <i class="fas fa-history fs-2 opacity-10 mb-4 d-block"></i>
                                <span class="fs-9 opacity-40 uppercase ls-2 d-block mb-6">No recent activity detected</span>
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
                                <span class="section-tag" style="color: var(--accent);">ACCOUNT_DASHBOARD</span>
                                <h1 class="display-5 fw-900 m-0 text-primary">WELCOME BACK, {{ auth()->user()->name }}</h1>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <div class="bg-elevated border border-white border-opacity-5 p-4">
                                    <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Total Acquisitions</span>
                                    <h2 class="display-6 fw-900 text-primary m-0">{{ $totalOrders }}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-elevated border border-white border-opacity-5 p-4 border-start border-warning border-4">
                                    <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Active Sequences</span>
                                    <h2 class="display-6 fw-900 text-warning m-0">{{ $pendingOrders }}</h2>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-elevated border border-white border-opacity-5 p-4 border-start border-success border-4">
                                    <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Finalized Shipments</span>
                                    <h2 class="display-6 fw-900 text-success m-0">{{ $completedOrders }}</h2>
                                </div>
                            </div>
                        </div>

                        <h3 class="fs-7 fw-950 text-primary ls-2 uppercase mb-4">RECENT ACTIVITY</h3>
                        @if($recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle border-0">
                                    <thead class="bg-body border-0">
                                        <tr class="fs-10 text-secondary opacity-50 uppercase ls-2">
                                            <th class="p-3 border-0">Order Hash</th>
                                            <th class="p-3 border-0">Date</th>
                                            <th class="p-3 border-0">Valuation</th>
                                            <th class="p-3 border-0">Status</th>
                                            <th class="p-3 border-0 text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-8">
                                        @foreach($recentOrders as $order)
                                            <tr class="border-bottom border-white border-opacity-5">
                                                <td class="p-3 border-0 fw-900 text-primary">#{{ $order->order_number }}</td>
                                                <td class="p-3 border-0 text-secondary">{{ $order->created_at->format('M d, Y') }}</td>
                                                <td class="p-3 border-0 fw-900 text-primary">৳{{ number_format($order->total) }}</td>
                                                <td class="p-3 border-0">
                                                    @php
                                                        $statusClass = $order->status == 'completed' ? 'text-success' : ($order->status == 'pending' ? 'text-warning' : 'text-primary');
                                                    @endphp
                                                    <span class="fw-950 uppercase ls-1 {{ $statusClass }}">{{ $order->status }}</span>
                                                </td>
                                                <td class="p-3 border-0 text-end">
                                                    <a href="{{ url('/account/orders/' . $order->id) }}" class="btn-pro btn-pro-outline py-2 px-3 fs-9">VIEW_DETAILS</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-5 text-center bg-elevated border border-white border-opacity-5">
                                <p class="text-secondary opacity-50 mb-4">No recent activity detected.</p>
                                <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-primary px-4 py-3 fs-9">INITIATE ACQUISITION</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
