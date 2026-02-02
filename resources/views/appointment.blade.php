@extends('layouts.app')

@section('title', 'Schedule Appointment | Drive Boosted Service Lab')

@push('styles')
<style>
    /* Multi-Phase Form Styling */
    .appointment-stepper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4rem;
        position: relative;
    }

    .appointment-stepper::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        width: 100%;
        height: 1px;
        background: var(--db-border-subtle);
        z-index: 0;
    }

    .step-item {
        position: relative;
        z-index: 1;
        background: var(--db-bg-body);
        padding: 0 20px;
        text-align: center;
    }

    .step-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-strong);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--db-font-heading);
        font-weight: 900;
        margin: 0 auto 15px;
        transition: var(--db-transition);
        color: var(--db-text-secondary);
    }

    .step-item.active .step-number {
        background: var(--db-accent);
        border-color: var(--db-accent);
        color: var(--db-accent-contrast);
        box-shadow: 0 0 20px var(--db-accent-glow);
    }

    .step-item.active .step-label {
        color: var(--db-text-primary);
        opacity: 1;
    }

    .step-label {
        font-size: 0.65rem;
        font-weight: 900;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        opacity: 0.3;
        transition: var(--db-transition);
    }

    /* Form Phases */
    .form-phase {
        display: none;
    }

    .form-phase.active {
        display: block;
        animation: slideInUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .big-input-group {
        margin-bottom: 2.5rem;
    }

    .big-input-group label {
        display: block;
        font-size: 0.7rem;
        font-weight: 900;
        color: var(--db-accent);
        letter-spacing: 0.2em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    /* Service Selection Grid */
    .service-selection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .selectable-service {
        cursor: pointer;
        padding: 30px;
        background: var(--db-bg-surface);
        border: 1px solid var(--db-border-subtle);
        transition: var(--db-transition);
        position: relative;
    }

    .selectable-service:hover {
        border-color: var(--db-accent-glow);
        background: var(--db-bg-elevated);
    }

    .selectable-service.selected {
        border-color: var(--db-accent);
        background: var(--db-accent-glow);
    }

    .selectable-service.selected::after {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 15px;
        right: 15px;
        color: var(--db-accent);
    }

    .nav-buttons {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid var(--db-border-subtle);
    }
</style>
@endpush

@section('content')
    <main class="appointment-page-pro pt-5 mt-5">
        <div class="nav-container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Header -->
                    <div class="text-center mb-12 reveal">
                        <span class="section-tag mb-3" style="color: var(--db-accent);">APPOINTMENT_REGISTRY</span>
                        <h1 class="display-3 ls-narrower m-0">BOOK APPOINTMENT_</h1>
                        <p class="fs-7 opacity-50 mt-4 uppercase ls-1">Follow the protocols to schedule your vehicle for elite care.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert glass-effect border border-accent bg-accent bg-opacity-10 text-accent p-5 mb-12 rounded-0 text-center reveal">
                            <i class="fas fa-check-circle d-block mb-3 fs-1"></i>
                            <h4 class="fw-900 ls-2 uppercase m-0">{{ session('success') }}</h4>
                            <p class="fs-9 opacity-70 mt-3 m-0">A laboratory technician will contact you for final verification.</p>
                        </div>
                    @endif

                    <!-- Stepper -->
                    <div class="appointment-stepper reveal">
                        <div class="step-item active" id="step1-indicator">
                            <div class="step-number">01</div>
                            <div class="step-label">Personal_Registry</div>
                        </div>
                        <div class="step-item" id="step2-indicator">
                            <div class="step-number">02</div>
                            <div class="step-label">Vehicle_Info</div>
                        </div>
                        <div class="step-item" id="step3-indicator">
                            <div class="step-number">03</div>
                            <div class="step-label">Protocol_Selection</div>
                        </div>
                    </div>

                    <!-- Multi-Phase Form -->
                    <form action="{{ route('appointment.store') }}" method="POST" id="appointmentForm" class="reveal">
                        @csrf
                        
                        <!-- Phase 1: Personal Info -->
                        <div class="form-phase active" id="phase1">
                            <div class="row g-5">
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Full Legal Name</label>
                                        <input type="text" name="customer_name" class="form-control" placeholder="ENTER NAME" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Encrypted Phone Protocol</label>
                                        <input type="tel" name="customer_phone" class="form-control" placeholder="PHONE NUMBER" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="big-input-group m-0">
                                        <label>Special Instructions / Manifest (Optional)</label>
                                        <textarea name="notes" class="form-control" rows="3" placeholder="DESCRIBE VEHICLE CONDITION OR SPECIFIC REQUESTS..."></textarea>
                                        <span class="fs-11 fw-950 opacity-30 ls-2 uppercase mt-2 d-block text-accent">Notice: Data auto-buffered for next step.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-buttons d-flex justify-content-end">
                                <button type="button" class="btn-pro btn-pro-primary next-phase" data-next="2">CONTINUE_TO_VEHICLE <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <!-- Phase 2: Vehicle Info -->
                        <div class="form-phase" id="phase2">
                            <div class="row g-5">
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Vehicle Make</label>
                                        <input type="text" name="vehicle_make" class="form-control" placeholder="e.g. TOYOTA / BMW" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Vehicle Model</label>
                                        <input type="text" name="vehicle_model" class="form-control" placeholder="e.g. PREMIO / M3" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Chassis Category</label>
                                        <select name="vehicle_type" class="form-control" required>
                                            <option value="" disabled selected>SELECT TYPE</option>
                                            <option value="sedan">SEDAN / EXECUTIVE</option>
                                            <option value="suv">SUV / CROSSOVER</option>
                                            <option value="coupe">COUPE / SPORT</option>
                                            <option value="luxury">ULTRA LUXURY</option>
                                            <option value="motorcycle">MOTORCYCLE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Licence Plate</label>
                                        <input type="text" name="licence_plate" class="form-control" placeholder="DHK-METRO-..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-buttons d-flex justify-content-between">
                                <button type="button" class="btn-pro btn-pro-outline prev-phase" data-prev="1"><i class="fas fa-arrow-left me-2"></i> BACK_TO_PERSONAL</button>
                                <button type="button" class="btn-pro btn-pro-primary next-phase" data-next="3">CONTINUE_TO_PROTOCOLS <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <!-- Phase 3: Date & Service Selection -->
                        <div class="form-phase" id="phase3">
                            <div class="row g-5 mb-5">
                                <div class="col-md-6">
                                    <div class="big-input-group">
                                        <label>Scheduled Admission Date</label>
                                        <input type="date" name="appointment_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="big-input-group w-100">
                                        <span class="fs-11 fw-950 text-accent ls-2 d-block uppercase mb-1">Total Estimated Investment</span>
                                        <span class="fs-4 fw-900 text-white" id="totalInvestmentDisplay">৳0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="big-input-group mb-5">
                                <label>Selection of Detailing Protocols (Multiple Selectable)</label>
                                <p class="fs-8 opacity-40 uppercase ls-1 mb-4">Choose one or more services for admission.</p>
                                
                                <div class="service-selection-grid">
                                    @foreach($services as $category => $items)
                                        @foreach($items as $svc)
                                        <div class="selectable-service {{ request('service') == $svc->id ? 'selected' : '' }}" data-id="{{ $svc->id }}" data-price="{{ (float)$svc->price }}">
                                            <span class="fs-10 opacity-30 ls-2 d-block mb-1 uppercase">{{ $category }}</span>
                                            <h4 class="fs-8 fw-900 m-0 ls-narrow">{{ $svc->name }}</h4>
                                            <span class="fs-10 text-accent mt-3 d-block fw-900">৳{{ number_format($svc->price) }}</span>
                                            
                                            <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" {{ request('service') == $svc->id ? 'checked' : '' }} class="d-none service-checkbox">
                                        </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="nav-buttons d-flex justify-content-between">
                                <button type="button" class="btn-pro btn-pro-outline prev-phase" data-prev="2"><i class="fas fa-arrow-left me-2"></i> BACK_TO_VEHICLE</button>
                                <button type="submit" class="btn-pro btn-pro-primary px-5 py-4">SECURE_APPOINTMENT <i class="fas fa-shield-halved ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Direct Support Bar -->
        <section class="section-padding bg-surface border-top border-white border-opacity-5">
            <div class="nav-container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-5">
                    <div class="d-flex align-items-center gap-4">
                        <div class="nav-icon fs-2 opacity-20"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <span class="fs-10 fw-950 opacity-30 ls-2 d-block uppercase">Voice Encryption</span>
                            <span class="fs-5 fw-900 text-primary">+880 1612 770066</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <div class="nav-icon fs-2 opacity-20"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="fs-10 fw-950 opacity-30 ls-2 d-block uppercase">Lab Location</span>
                            <span class="fs-5 fw-900 text-primary">DHAKA_CENTRAL_STATION</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <div class="nav-icon fs-2 opacity-20"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <span class="fs-10 fw-950 opacity-30 ls-2 d-block uppercase">Security Protocol</span>
                            <span class="fs-5 fw-900 text-primary">MIL_GRADE_CERTIFIED</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function updateTotal() {
            let total = 0;
            $('.selectable-service.selected').each(function() {
                total += parseFloat($(this).data('price'));
            });
            $('#totalInvestmentDisplay').text('৳' + total.toLocaleString());
        }

        // Initial Total for pre-selected service
        updateTotal();

        // Phase Navigation
        $('.next-phase').click(function() {
            const next = $(this).data('next');
            const $current = $('.form-phase.active');
            
            // Basic Validation for current phase
            let valid = true;
            $current.find('input[required], select[required]').each(function() {
                if(!this.value) {
                    valid = false;
                    $(this).css('border-color', 'var(--db-accent)');
                } else {
                    $(this).css('border-color', '');
                }
            });

            if(valid) {
                $('.form-phase').removeClass('active');
                $(`#phase${next}`).addClass('active');
                $('.step-item').removeClass('active');
                for(let i=1; i<=next; i++) {
                    $(`#step${i}-indicator`).addClass('active');
                }
                window.scrollTo({ top: 300, behavior: 'smooth' });
            }
        });

        $('.prev-phase').click(function() {
            const prev = $(this).data('prev');
            $('.form-phase').removeClass('active');
            $(`#phase${prev}`).addClass('active');
            $('.step-item').each(function(idx) {
                if(idx + 1 > prev) $(this).removeClass('active');
            });
        });

        // Service Selection (Multi-select)
        $('.selectable-service').click(function() {
            const $checkbox = $(this).find('.service-checkbox');
            $(this).toggleClass('selected');
            $checkbox.prop('checked', $(this).hasClass('selected'));
            updateTotal();
        });

        // Prevention of phase 3 continuation without services
        $('#appointmentForm').submit(function(e) {
            if($('.service-checkbox:checked').length === 0) {
                e.preventDefault();
                alert("CRITICAL: Minimum one detailing protocol must be selected.");
            }
        });
    });
</script>
@endpush
