@extends('layouts.app')

@section('title', 'Order Confirmation | Drive Boosted')

@section('content')
    <main class="confirmation-page-pro pt-5 mt-5">
        <div class="nav-container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-fade-up">
                    <div class="success-icon mb-4" style="font-size: 5rem; color: var(--accent);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h1 class="display-4 fw-900 text-primary ls-narrower mb-3 uppercase">SEQUENCE_CONFIRMED</h1>
                    <p class="fs-6 text-secondary opacity-60 mb-5 pb-3 border-bottom border-white border-opacity-5 d-inline-block px-5">Order #{{ $order->order_number }} has been successfully recorded.</p>
                    
                    <div class="booking-summary-card bg-surface border border-white border-opacity-5 p-4 p-md-5 text-start animate-fade-up" style="animation-delay: 0.1s;">
                        <div class="row g-4 mb-5 border-bottom border-white border-opacity-5 pb-4">
                            <div class="col-md-6">
                                <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Customer Details</span>
                                <h3 class="fs-7 fw-900 text-primary m-0 uppercase">{{ $order->customer_name }}</h3>
                                <p class="fs-8 text-secondary opacity-60 m-0">{{ $order->customer_phone }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-1">Order Date</span>
                                <h3 class="fs-7 fw-900 text-primary m-0 uppercase">{{ $order->created_at->format('M d, Y') }}</h3>
                                <p class="fs-8 text-secondary opacity-60 m-0">{{ $order->created_at->format('H:i') }} UTC</p>
                            </div>
                        </div>

                        <div class="order-items-list mb-5">
                            <span class="fs-10 fw-950 text-secondary opacity-40 ls-2 uppercase d-block mb-4">Acquisition List</span>
                            @foreach($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="fs-8 fw-900 text-primary m-0 uppercase">{{ $item->product_name }}</h4>
                                    <span class="fs-10 text-secondary opacity-40 uppercase ls-1">QTY x {{ $item->quantity }}</span>
                                </div>
                                <span class="fs-7 fw-900 text-primary">৳{{ number_format($item->subtotal) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="total-row bg-elevated p-4 border border-white border-opacity-5">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fs-9 fw-900 text-secondary opacity-40 uppercase ls-1">Subtotal</span>
                                <span class="fs-8 fw-900 text-primary">৳{{ number_format($order->subtotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fs-9 fw-900 text-secondary opacity-40 uppercase ls-1">Shipping</span>
                                <span class="fs-8 fw-900 text-accent uppercase ls-1">Free_Admission</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top border-white border-opacity-10">
                                <span class="fs-7 fw-950 text-primary uppercase ls-2">Total Amount</span>
                                <span class="fs-4 fw-950 text-accent">৳{{ number_format($order->total) }}</span>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <div class="d-inline-block p-4 border border-accent border-opacity-20 bg-accent bg-opacity-5">
                                <p class="fs-9 text-accent fw-900 m-0 uppercase ls-1">Our team will contact you shortly to confirm the shipment sequence.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-3">
                        <a href="{{ url('/catalog') }}" class="btn-pro btn-pro-primary px-5 py-3 fs-8 fw-950 ls-3 uppercase">CONTINUE EXPLORING</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
