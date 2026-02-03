@extends('layouts.app')

@section('title', 'Profile Settings | Drive Boosted')

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
                            <a href="{{ route('account.dashboard') }}" class="text-decoration-none text-white opacity-50 hover-opacity-100 fs-10 fw-950 ls-2 uppercase"><i class="fas fa-long-arrow-alt-left me-2"></i> RETURN TO DASHBOARD</a>
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-8 pb-6 border-bottom border-white border-opacity-5">
                            <div>
                                <span class="section-tag mb-3 d-block" style="color: var(--db-accent);">IDENTITY_MANAGEMENT</span>
                                <h1 class="display-5 fw-950 m-0 ls-narrower">PROFILE SETTINGS</h1>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success bg-opacity-10 text-success border-success rounded-0 mb-5 fs-9 fw-bold">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('account.profile.update') }}" method="POST">
                            @csrf
                            <div class="row g-5">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fs-10 fw-950 text-white opacity-60 ls-2 uppercase mb-2">Full Legal Name</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fs-10 fw-950 text-white opacity-60 ls-2 uppercase mb-2">Email Address (Locked)</label>
                                        <input type="email" value="{{ $user->email }}" class="form-control opacity-50" disabled style="cursor: not-allowed;">
                                        <span class="fs-10 text-white opacity-30 mt-1 d-block">Contact support to change email.</span>
                                    </div>
                                </div>
                                
                                <div class="col-12 border-top border-white border-opacity-5 my-2"></div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fs-10 fw-950 text-white opacity-60 ls-2 uppercase mb-2">New Password (Optional)</label>
                                        <input type="password" name="password" class="form-control" placeholder="LEAVE EMPTY TO KEEP CURRENT">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fs-10 fw-950 text-white opacity-60 ls-2 uppercase mb-2">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="REPEAT NEW PASSWORD">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 text-end">
                                <button type="submit" class="btn-pro btn-pro-primary px-5 py-3">SAVE CHANGES <i class="fas fa-save ms-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
