@extends('layouts.app')

@section('title', 'Service Showroom | Drive Boosted')

@push('styles')
<style>
    /* Services Categorical Styling */
    .services-nav-sticky {
        position: sticky;
        top: var(--db-nav-height);
        background: var(--db-bg-glass-strong);
        backdrop-filter: blur(10px);
        z-index: 100;
        border-bottom: var(--db-glass-border);
    }

    .service-category-section {
        padding-top: 100px;
        margin-top: -50px;
    }

    .category-header {
        position: relative;
        padding-bottom: 2rem;
        margin-bottom: 4rem;
        border-bottom: 1px solid var(--db-border-subtle);
    }

    .category-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100px;
        height: 1px;
        background: var(--db-accent);
    }

    .hover-reveal-img {
        position: absolute;
        inset: 0;
        z-index: 0;
        opacity: 0;
        transition: var(--db-transition);
        transform: scale(1.1);
    }

    .service-card-modern:hover .hover-reveal-img {
        opacity: 0.2;
        transform: scale(1);
    }

    .service-item-content {
        position: relative;
        z-index: 1;
    }

    .price-tag-pro {
        font-family: var(--db-font-heading);
        font-weight: 950;
        color: var(--db-accent);
        border-left: 2px solid var(--db-accent);
        padding-left: 15px;
    }
</style>
@endpush

@section('content')
    <main class="service-page-pro">
        <!-- Cinematic Hero -->
        <section class="lab-hero position-relative d-flex align-items-center justify-content-center overflow-hidden" style="height: 60vh;">
            <div class="position-absolute w-100 h-100" style="background: url('https://images.unsplash.com/photo-1621370211603-9bb64be084cd?auto=format&fit=crop&q=80&w=2000') center center/cover; filter: brightness(0.3) saturate(1.2);"></div>
            <div class="hero-overlay" style="background: linear-gradient(to bottom, transparent, var(--db-bg-body));"></div>
            <div class="nav-container text-center position-relative z-index-1 reveal">
                <span class="section-tag mb-4 shadow-text" style="color: var(--db-accent);">DRIVE BOOSTED PROTOCOLS</span>
                <h1 class="display-2 ls-narrower text-white m-0">SERVICE_LAB</h1>
                <p class="fs-6 fw-500 text-white opacity-60 mt-4 ls-1 uppercase">Precision engineering for every surface of your machine.</p>
            </div>
        </section>

        <!-- Category Shortcut Nav -->
        <div class="services-nav-sticky">
            <div class="nav-container">
                <div class="d-flex gap-5 overflow-auto py-3 no-scrollbar">
                    @foreach($services as $category => $items)
                    <a href="#{{ Str::slug($category) }}" class="nav-link-rsa whitespace-nowrap opacity-50 hover-opacity-100">{{ strtoupper($category) }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="nav-container py-5">
            @foreach($services as $category => $items)
            <section id="{{ Str::slug($category) }}" class="service-category-section mb-5">
                <div class="category-header reveal">
                    <span class="fs-9 fw-950 text-accent ls-4 uppercase d-block mb-3">SECTOR_0{{ $loop->iteration }}</span>
                    <h2 class="display-5 ls-narrower m-0">{{ $category }}</h2>
                </div>

                <div class="row g-4">
                    @foreach($items as $idx => $service)
                    <div class="col-lg-6">
                        <div class="service-card-modern reveal bg-surface border-white border-opacity-5 p-0 d-flex flex-column h-100 group-hover-trigger overflow-hidden" style="transition-delay: {{ $idx * 0.1 }}s;">
                            <a href="{{ route('services.show', $service->id) }}" class="position-relative d-block overflow-hidden" style="height: 300px;">
                                <img src="{{ $service->image }}?auto=format&fit=crop&q=80&w=1000" class="hover-reveal-img object-fit-cover w-100 h-100" alt="{{ $service->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1621370211603-9bb64be084cd?auto=format&fit=crop&q=80&w=1000'">
                                <div class="position-absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
                            </a>
                            
                            <div class="service-item-content p-5">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <h3 class="fs-4 fw-900 ls-narrower m-0"><a href="{{ route('services.show', $service->id) }}" class="text-white text-decoration-none">{{ $service->name }}</a></h3>
                                    <div class="price-tag-pro">
                                        <span class="fs-10 opacity-50 d-block ls-2">STARTS_FROM</span>
                                        <span class="fs-5">৳{{ number_format($service->price) }}</span>
                                    </div>
                                </div>
                                
                                <p class="fs-7 opacity-50 mb-5" style="max-height: 80px; overflow: hidden; line-height: 1.8;">{{ $service->description }}</p>
                                
                                <div class="tech-specs-row d-flex gap-5 mb-5 border-top border-white border-opacity-10 pt-4">
                                    <div class="tech-item">
                                        <span class="fs-11 fw-950 opacity-30 ls-2 d-block uppercase mb-1">Duration</span>
                                        <span class="fs-9 fw-900 text-primary uppercase ls-1">{{ $service->duration }}</span>
                                    </div>
                                    <div class="tech-item ps-4 border-start border-white border-opacity-10">
                                        <span class="fs-11 fw-950 opacity-30 ls-2 d-block uppercase mb-1">Standard</span>
                                        <span class="fs-9 fw-900 text-accent uppercase ls-1">Elite_Grade</span>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <a href="{{ route('appointment.create', ['service' => $service->id]) }}" class="btn-pro btn-pro-primary flex-grow-1 py-3 fs-9 uppercasels-2">BOOK APPOINTMENT</a>
                                    <a href="{{ route('services.show', $service->id) }}" class="btn-pro btn-pro-outline py-3 px-4 fs-9 uppercasels-2">DETAILS</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endforeach
        </div>

        <!-- Trust & Lab Section -->
        <section class="section-padding bg-elevated border-top border-white border-opacity-5">
            <div class="nav-container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-lg-8 reveal">
                        <span class="section-tag mb-4 shadow-text" style="color: var(--db-accent);">CLINICAL ENVIRONMENT</span>
                        <h2 class="display-3 ls-narrower mb-5">PREPPED FOR PERFECTION_</h2>
                        <p class="fs-6 opacity-50 mb-5 mx-auto" style="max-width: 700px; line-height: 2;">Our Dhaka studio is a climate-controlled environment designed to ensure that covalent bonding and surface restoration occur under optimal chemical conditions. No corners cut. No microns missed.</p>
                        <div class="d-flex gap-5 justify-content-center">
                            <div class="stat-item">
                                <span class="d-block fs-2 fw-900 text-primary">100%</span>
                                <span class="fs-10 fw-950 opacity-30 ls-2 uppercase">Dust Control</span>
                            </div>
                            <div class="stat-item">
                                <span class="d-block fs-2 fw-900 text-primary">99.9%</span>
                                <span class="fs-10 fw-950 opacity-30 ls-2 uppercase">Accuracy</span>
                            </div>
                            <div class="stat-item">
                                <span class="d-block fs-2 fw-900 text-primary">24/7</span>
                                <span class="fs-10 fw-950 opacity-30 ls-2 uppercase">Surveillance</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
