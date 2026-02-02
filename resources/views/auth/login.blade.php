@extends('layouts.app')

@section('title', 'Secure Access | Drive Boosted')

@push('styles')
<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: stretch;
        padding-top: var(--db-nav-height);
        background: var(--db-bg-body);
    }

    .auth-visual {
        flex: 1;
        background-color: #000;
        background-image: url('https://cdn.shopify.com/s/files/1/0793/0216/4717/files/DB_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'); 
        background-size: cover;
        background-position: center;
        position: relative;
        display: none;
    }

    @media (min-width: 992px) {
        .auth-visual {
            display: block;
        }
    }

    .auth-visual::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0,0,0,0.3), var(--db-bg-body));
    }

    .auth-visual-content {
        position: absolute;
        bottom: 10%;
        left: 10%;
        z-index: 2;
        max-width: 400px;
    }

    .auth-form-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        max-width: 800px; /* Limit width on large screens */
    }

    .auth-card {
        width: 100%;
        max-width: 450px;
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 60px;
        border-radius: var(--db-radius);
        position: relative;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--db-accent), transparent);
    }

    .form-floating > .form-control {
        background: var(--db-bg-body);
        border: 1px solid var(--db-border-subtle);
        color: var(--db-text-primary);
    }
    
    .form-floating > .form-control:focus {
        border-color: var(--db-accent);
        box-shadow: 0 0 0 1px var(--db-accent-glow);
    }

    .form-floating > label {
        color: var(--db-text-secondary);
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-visual">
        <div class="auth-visual-content reveal">
            <span class="fs-11 fw-950 text-accent uppercase ls-2 mb-3 d-block">Elite Membership</span>
            <h2 class="display-5 fw-900 text-white mb-4">ACCESS YOUR<br>GARAGE_</h2>
            <p class="fs-7 opacity-70">Track orders, manage subscriptions, and access exclusive detailing protocols.</p>
        </div>
    </div>
    
    <div class="auth-form-container">
        <div class="auth-card reveal" style="transition-delay: 0.2s;">
            <div class="text-center mb-10">
                <i class="fas fa-fingerprint fs-1 text-accent mb-6"></i>
                <h1 class="fs-4 fw-950 uppercase ls-2 m-0">Secure Login</h1>
                <p class="fs-10 opacity-50 mt-3 uppercase ls-1">Enter Credentials</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required autofocus>
                    <label for="email">EMAIL_ID</label>
                </div>

                <div class="form-floating mb-6">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password">ACCESS_KEY</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label fs-10 uppercase ls-1 opacity-70" for="remember">
                            Remember Device
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="fs-10 text-accent text-decoration-none uppercase ls-1 fw-700" href="{{ route('password.request') }}">
                            Reset Key?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-pro btn-pro-primary w-100 py-4 fs-8 fw-950 ls-2 uppercase">
                    AUTHENTICATE
                </button>

                <div class="mt-8 text-center">
                    <span class="fs-10 opacity-50 uppercase ls-1">New to Drive Boosted?</span>
                    <a href="{{ route('register') }}" class="d-block mt-2 fs-9 text-white fw-900 uppercase ls-1 text-decoration-none border-bottom border-accent d-inline-block pb-1">Initialize Registration</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
