@extends('layouts.app')

@section('title', $service->name . ' | Drive Boosted')

@push('styles')
<style>
    .service-hero {
        height: 60vh;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        background: var(--db-bg-body);
    }

    .service-hero-bg {
        position: absolute;
        inset: 0;
        background: url('{{ $service->image }}?auto=format&fit=crop&q=80&w=2000') center center/cover;
        filter: brightness(0.4);
        z-index: 1;
    }

    .service-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
    }

    .package-card {
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        padding: 40px;
        height: 100%;
        transition: var(--db-transition);
    }

    .package-card:hover {
        border-color: var(--db-accent);
        transform: translateY(-5px);
    }

    .bullet-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .bullet-list li {
        padding: 12px 0;
        padding-left: 30px;
        position: relative;
        font-size: 0.9rem;
        color: var(--db-text-secondary);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .bullet-list li:last-child {
        border-bottom: none;
    }

    .bullet-list li::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        left: 0;
        color: var(--db-accent);
        font-size: 0.8rem;
    }

    .service-sidebar {
        position: sticky;
        top: 100px;
    }
</style>
@endpush

@section('content')
<main>
    <section class="service-hero">
        <div class="service-hero-bg"></div>
        <div class="nav-container">
            <div class="service-hero-content reveal">
                <span class="section-tag mb-4 shadow-text" style="color: var(--db-accent);">LAB_PROTOCOL / {{ strtoupper($service->category) }}</span>
                <h1 class="display-2 ls-narrower text-white mb-4">{{ $service->name }}</h1>
                <p class="fs-5 text-white opacity-60 mb-5">{{ $service->description }}</p>
                <div class="d-flex gap-4 align-items-center">
                    <div class="price-display">
                        <span class="fs-10 fw-950 opacity-40 ls-2 d-block uppercase mb-1">STARTS_FROM</span>
                        <span class="fs-3 fw-900 text-white">৳{{ number_format($service->price) }}</span>
                    </div>
                    <div class="ms-4 ps-4 border-start border-white border-opacity-10">
                        <span class="fs-10 fw-950 opacity-40 ls-2 d-block uppercase mb-1">DURATION</span>
                        <span class="fs-3 fw-900 text-primary">{{ $service->duration }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-body">
        <div class="nav-container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="mb-5 reveal">
                        <h2 class="display-5 ls-narrower mb-4">WHAT INCLUDES IN OUR<br>{{ strtoupper($service->name) }} PACKAGE_</h2>
                        <div class="package-card">
                            <ul class="bullet-list">
                                <li>Ph-Neutral Snow Foam Soak & Rinse</li>
                                <li>Two-Bucket Method Professional Contact Wash</li>
                                <li>Iron & Fallout Chemical Decontamination</li>
                                <li>Mechanical Clay Bar Treatment (If required)</li>
                                <li>Multi-Stage Surface Preparation</li>
                                <li>Precision Application of Chosen Protectant</li>
                                <li>Final Inspection under High-Intensity Lighting</li>
                                <li>Microfiber Buff to Mirror Finish</li>
                            </ul>
                        </div>
                    </div>

                    <div class="reveal">
                        <h2 class="display-5 ls-narrower mb-4">ENGINEERING HIGHLIGHTS_</h2>
                        <p class="fs-6 opacity-60 mb-5" style="line-height: 2;">Our approach to {{ strtolower($service->name) }} involves meticulous attention to every micron of the surface. We utilize clinical-grade formulations and specialized equipment to ensure a finish that doesn't just look spectacular but provides long-lasting structural protection for your vehicle's aesthetics.</p>
                        
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="bg-surface border-white border-opacity-5 p-4">
                                    <i class="fas fa-microscope text-accent mb-3 fs-3"></i>
                                    <h4 class="fs-6 fw-900 ls-1 mb-2">CLINICAL PRECISION</h4>
                                    <p class="fs-9 opacity-50 m-0">Laboratory tested application protocols.</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="bg-surface border-white border-opacity-5 p-4">
                                    <i class="fas fa-shield-alt text-primary mb-3 fs-3"></i>
                                    <h4 class="fs-6 fw-900 ls-1 mb-2">MAX PROTECTION</h4>
                                    <p class="fs-9 opacity-50 m-0">Covalent bonding for extreme durability.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="service-sidebar reveal">
                        <div class="bg-surface border-white border-opacity-5 p-5">
                            <h3 class="fs-5 fw-950 ls-2 mb-4">SECURE YOUR SESSION</h3>
                            <p class="fs-8 opacity-50 mb-5 mt-2">Book your slot in our detailing lab now. Spaces are limited for elite-grade sessions.</p>
                            
                            <a href="{{ route('appointment.create', ['service' => $service->id]) }}" class="btn-pro btn-pro-primary w-100 py-4 mb-3">BOOK NOW</a>
                            
                            <div class="text-center mt-4">
                                <span class="fs-10 opacity-30 ls-2 uppercase">Need Guidance?</span>
                                <div class="d-flex gap-3 justify-content-center mt-3">
                                    <a href="tel:+8801988555000" class="nav-icon"><i class="fas fa-phone"></i></a>
                                    <a href="#" class="nav-icon"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="fs-8 fw-950 ls-2 mb-4 opacity-40">OTHER PROTOCOLS_</h4>
                            @foreach($relatedServices as $rel)
                            <a href="{{ route('services.show', $rel->id) }}" class="d-flex align-items-center gap-3 mb-4 text-decoration-none group">
                                <div class="img-wrapper rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
                                    <img src="{{ $rel->image }}?auto=format&fit=crop&q=80&w=100" class="w-100 h-100 object-fit-cover transition-transform group-hover-scale" alt="{{ $rel->name }}">
                                </div>
                                <div>
                                    <h5 class="fs-9 fw-900 text-white m-0 uppercase">{{ $rel->name }}</h5>
                                    <span class="fs-11 text-accent ls-1 fw-700">৳{{ number_format($rel->price) }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
