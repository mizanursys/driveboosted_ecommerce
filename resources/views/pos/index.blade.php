@extends('layouts.app')

@section('content')
<div class="pos-container py-4">
    <div class="container-fluid">
        @if(!$activeSession)
        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-md-4 text-center">
                <div class="glass-card p-5">
                    <div class="mb-4">
                        <i class="fas fa-cash-register fa-4x text-primary"></i>
                    </div>
                    <h2 class="mb-4">POS Session Closed</h2>
                    <p class="text-secondary mb-4">Please open a new session to start processing sales.</p>
                    <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#openSessionModal">
                        Open New Session
                    </button>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <!-- Products Side -->
            <div class="col-md-8">
                <div class="glass-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-arrow-left me-1"></i> Shop</a>
                            <h4 class="mb-0">Products</h4>
                        </div>
                        <div class="input-group w-50">
                            <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search"></i></span>
                            <input type="text" id="productSearch" class="form-control bg-transparent border-start-0" placeholder="Search by name or SKU...">
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="categories-filter mb-4 pb-2 overflow-auto d-flex" style="white-space: nowrap;">
                        <button class="btn btn-outline-primary me-2 active filter-category" data-category="all">All</button>
                        @foreach($categories as $category)
                        <button class="btn btn-outline-primary me-2 filter-category" data-category="{{ $category->id }}">{{ $category->name }}</button>
                        @endforeach
                    </div>

                    <!-- Product Grid -->
                    <div class="product-grid row g-3" id="posProductGrid">
                        @foreach($products as $product)
                        <div class="col-md-3 product-item" data-category="{{ $product->category_id }}" data-name="{{ strtolower($product->name) }}" data-sku="{{ strtolower($product->sku) }}">
                            <div class="glass-card h-100 p-2 text-center pos-product-card" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset($product->image) }}')">
                                <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-2" style="height: 100px; width: 100%; object-fit: contain; background: #000;">
                                <h6 class="text-truncate mb-1">{{ $product->name }}</h6>
                                <p class="text-primary fw-bold mb-0">৳{{ number_format($product->price) }}</p>
                                <small class="text-secondary">Stock: {{ $product->stock_quantity }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Side -->
            <div class="col-md-4">
                <div class="glass-card p-4 h-100 d-flex flex-column" style="min-height: 80vh;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Current Order</h4>
                        <button class="btn btn-sm btn-outline-danger" onclick="clearCart()"><i class="fas fa-trash"></i></button>
                    </div>

                    <div class="cart-items flex-grow-1 overflow-auto mb-4" id="posCartItems">
                        <!-- Items will be injected here -->
                    </div>

                    <div class="cart-summary border-top pt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="posSubtotal">৳0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="d-flex align-items-center">
                                Discount 
                                <select id="discountType" class="form-select form-select-sm ms-2" style="width: auto;" onchange="updateTotals()">
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">%</option>
                                </select>
                            </span>
                            <input type="number" id="discountValue" class="form-control form-control-sm ms-2 text-end" style="width: 80px;" value="0" oninput="updateTotals()">
                        </div>
                        <div class="d-flex justify-content-between mb-4 mt-3 border-top pt-3">
                            <h4 class="mb-0">Total</h4>
                            <h4 class="mb-0 text-primary" id="posTotal">৳0</h4>
                        </div>
                        <button class="btn btn-primary btn-lg w-100" id="checkoutBtn" onclick="openPaymentModal()" disabled>
                            Pay Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Open Session Modal -->
<div class="modal fade" id="openSessionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card">
            <div class="modal-header border-0">
                <h5 class="modal-title">Open New Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pos.session.open') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Opening Cash (BDT)</label>
                        <input type="number" name="opening_cash" class="form-control" required step="0.01" value="0">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Open Session</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card">
            <div class="modal-header border-0">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 border-end">
                        <div class="mb-4">
                            <h6 class="text-secondary mb-3">Order Summary</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="modalSubtotal">৳0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Discount:</span>
                                <span id="modalDiscount">৳0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <h4 class="mb-0">Total Payable:</h4>
                                <h4 class="mb-0 text-primary" id="modalTotal">৳0</h4>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-secondary mb-3">Customer Information (Optional)</h6>
                            <input type="text" id="custName" class="form-control mb-2" placeholder="Customer Name">
                            <input type="tel" id="custPhone" class="form-control mb-2" placeholder="Phone Number">
                            <input type="email" id="custEmail" class="form-control" placeholder="Email Address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-secondary mb-3">Payment Details</h6>
                        <div class="mb-4">
                            <label class="form-label">Payment Method</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="payMethod" id="payCash" value="cash" checked autocomplete="off" onchange="toggleCashFields()">
                                <label class="btn btn-outline-primary flex-grow-1" for="payCash">Cash</label>

                                <input type="radio" class="btn-check" name="payMethod" id="payCard" value="card" autocomplete="off" onchange="toggleCashFields()">
                                <label class="btn btn-outline-primary flex-grow-1" for="payCard">Card</label>

                                <input type="radio" class="btn-check" name="payMethod" id="payMfs" value="mfs" autocomplete="off" onchange="toggleCashFields()">
                                <label class="btn btn-outline-primary flex-grow-1" for="payMfs">MFS</label>
                            </div>
                        </div>

                        <div id="cashFields">
                            <div class="mb-3">
                                <label class="form-label">Amount Paid</label>
                                <input type="number" id="amtPaid" class="form-control form-control-lg text-primary fw-bold" step="0.01" oninput="calculateChange()">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Change Due</label>
                                <h2 class="text-warning" id="amtChange">৳0</h2>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-lg w-100 mt-4" id="processSaleBtn" onclick="processSale()">
                            Complete Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = [];
    const CSRF_TOKEN = '{{ csrf_token() }}';

    function addToCart(id, name, price, image) {
        const index = cart.findIndex(item => item.id === id);
        if (index > -1) {
            cart[index].quantity++;
        } else {
            cart.push({ id, name, price, image, quantity: 1 });
        }
        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    function updateQuantity(id, qty) {
        const index = cart.findIndex(item => item.id === id);
        if (index > -1) {
            cart[index].quantity = parseInt(qty);
            if (cart[index].quantity <= 0) {
                removeFromCart(id);
            }
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('posCartItems');
        container.innerHTML = '';

        cart.forEach(item => {
            container.innerHTML += `
                <div class="cart-item-row glass-card p-3 mb-2 d-flex align-items-center">
                    <img src="${item.image}" alt="${item.name}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 text-truncate" style="max-width: 150px;">${item.name}</h6>
                        <small class="text-secondary">৳${item.price.toLocaleString()}</small>
                    </div>
                    <div class="quantity-controls d-flex align-items-center gap-2 mx-3">
                        <button class="btn btn-sm btn-outline-secondary px-2" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <span class="fw-bold">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary px-2" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                    <div class="text-end" style="min-width: 80px;">
                        <span class="fw-bold text-primary">৳${(item.price * item.quantity).toLocaleString()}</span>
                    </div>
                </div>
            `;
        });

        updateTotals();
        document.getElementById('checkoutBtn').disabled = cart.length === 0;
    }

    function updateTotals() {
        const subtotal = cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
        const discountValue = parseFloat(document.getElementById('discountValue').value) || 0;
        const discountType = document.getElementById('discountType').value;
        
        let discount = 0;
        if (discountType === 'percentage') {
            discount = subtotal * (discountValue / 100);
        } else {
            discount = discountValue;
        }

        const total = Math.max(0, subtotal - discount);

        document.getElementById('posSubtotal').innerText = '৳' + subtotal.toLocaleString();
        document.getElementById('posTotal').innerText = '৳' + total.toLocaleString();

        // Update modal values too
        if (document.getElementById('modalSubtotal')) {
            document.getElementById('modalSubtotal').innerText = '৳' + subtotal.toLocaleString();
            document.getElementById('modalDiscount').innerText = '৳' + discount.toLocaleString();
            document.getElementById('modalTotal').innerText = '৳' + total.toLocaleString();
            document.getElementById('amtPaid').value = total;
            calculateChange();
        }
    }

    function clearCart() {
        if (confirm('Clear current order?')) {
            cart = [];
            renderCart();
        }
    }

    function openPaymentModal() {
        if (cart.length === 0) return;
        updateTotals();
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();
    }

    function toggleCashFields() {
        const method = document.querySelector('input[name="payMethod"]:checked').value;
        const fields = document.getElementById('cashFields');
        if (method === 'cash') {
            fields.style.display = 'block';
        } else {
            fields.style.display = 'none';
        }
    }

    function calculateChange() {
        const total = parseFloat(document.getElementById('modalTotal').innerText.replace('৳', '').replace(/,/g, ''));
        const paid = parseFloat(document.getElementById('amtPaid').value) || 0;
        const change = Math.max(0, paid - total);
        document.getElementById('amtChange').innerText = '৳' + change.toLocaleString();
    }

    async function processSale() {
        const btn = document.getElementById('processSaleBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';

        const data = {
            items: cart,
            customer_name: document.getElementById('custName').value,
            customer_phone: document.getElementById('custPhone').value,
            customer_email: document.getElementById('custEmail').value,
            payment_method: document.querySelector('input[name="payMethod"]:checked').value,
            discount_amount: parseFloat(document.getElementById('discountValue').value) || 0,
            discount_type: document.getElementById('discountType').value,
            paid_amount: parseFloat(document.getElementById('amtPaid').value) || 0,
            _token: CSRF_TOKEN
        };

        try {
            const response = await fetch('{{ route("pos.order.store") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                // Open receipt in new tab and refresh POS
                window.open(result.redirect, '_blank');
                location.reload();
            } else {
                alert('Sale failed: ' + result.message);
                btn.disabled = false;
                btn.innerText = 'Complete Sale';
            }
        } catch (error) {
            console.error(error);
            alert('An error occurred');
            btn.disabled = false;
            btn.innerText = 'Complete Sale';
        }
    }

    // Search and Filter Logic
    document.getElementById('productSearch').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        filterProducts();
    });

    document.querySelectorAll('.filter-category').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-category').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterProducts();
        });
    });

    function filterProducts() {
        const query = document.getElementById('productSearch').value.toLowerCase();
        const category = document.querySelector('.filter-category.active').dataset.category;

        document.querySelectorAll('.product-item').forEach(item => {
            const matchesQuery = item.dataset.name.includes(query) || item.dataset.sku.includes(query);
            const matchesCategory = category === 'all' || item.dataset.category === category;

            if (matchesQuery && matchesCategory) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endpush

    .text-primary { color: var(--accent) !important; }
    .btn-primary { background: var(--accent) !important; border-color: var(--accent) !important; }
    .btn-outline-primary { color: var(--accent) !important; border-color: var(--accent) !important; }
    .btn-outline-primary.active { background: var(--accent) !important; color: #fff !important; }
</style>
@endsection
