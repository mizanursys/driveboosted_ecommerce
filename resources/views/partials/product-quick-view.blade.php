<div class="row g-0">
    <div class="col-md-6">
        <div class="qv-img-wrapper p-5 bg-surface h-100 d-flex align-items-center justify-content-center">
            <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset($product->image) }}" 
                 class="img-fluid" 
                 alt="{{ $product->name }}"
                 onerror="this.src='https://cdn.shopify.com/s/files/1/0793/0216/4717/files/RSA_PRODUCTS_1587_x_1700_px_13.png?v=1768818786'">
        </div>
    </div>
    <div class="col-md-6">
        <div class="qv-details p-5">
            <span class="section-tag mb-3">{{ $product->category->name ?? 'GEAR' }}</span>
            <h2 class="display-4 fw-900 mb-2">{{ $product->name }}</h2>
            <div class="p-price mb-4">
                <span>৳</span>{{ number_format($product->price) }}
            </div>
            <p class="fs-7 opacity-50 mb-5">{{ $product->description }}</p>
            
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-cart-form">
                @csrf
                <div class="d-flex gap-3">
                    <input type="number" name="quantity" value="1" min="1" class="form-control bg-surface border-white border-opacity-10 text-white text-center" style="width: 80px;">
                    <button type="submit" class="btn-pro btn-pro-primary flex-grow-1">ADD TO BAG</button>
                </div>
            </form>
            
            <div class="mt-5 pt-5 border-top border-white border-opacity-5">
                <a href="{{ route('product.show', $product->slug) }}" class="nav-link-pro fs-8 ls-2 text-decoration-none text-primary uppercase fw-900">VIEW PRODUCT DETAILS <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</div>
