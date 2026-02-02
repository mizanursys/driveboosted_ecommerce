@props(['product'])
<div class="product-card glass">
    <a href="{{ route('product.show', $product->slug) }}" class="product-link">
        <div class="image-wrapper">
            <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="product-image"
                 loading="lazy">
        </div>
        <div class="product-info">
            <p class="category-name text-uppercase">{{ $product->category->name ?? 'Car Care' }}</p>
            <h3 class="product-title">{{ $product->name }}</h3>
            <div class="price-container">
                <span class="currency">৳</span>
                <span class="price-value">{{ number_format($product->price) }}</span>
            </div>
        </div>
    </a>
    <div class="product-actions">
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-add-cart">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>
        </form>
    </div>
</div>

<style>
.product-card {
    position: relative;
    border-radius: 24px;
    padding: 20px;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.product-card:hover {
    transform: translateY(-12px) scale(1.02);
    border-color: var(--primary-accent);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.product-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 10;
    display: flex;
    gap: 8px;
}

.badge {
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.badge.featured {
    background: linear-gradient(45deg, #00d2ff, #3a7bd5);
    color: white;
}

.badge.sale {
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
    color: white;
}

.image-wrapper {
    width: 100%;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    overflow: hidden;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.02);
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.6s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.category-name {
    color: var(--primary-accent);
    font-size: 0.75rem;
    font-weight: 800;
    margin-bottom: 6px;
    letter-spacing: 2px;
    opacity: 0.8;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.4;
    color: #fff;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 3.1rem;
}

.price-container {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-top: auto;
}

.currency {
    font-size: 1rem;
    font-weight: 500;
    color: var(--text-muted);
}

.price-value {
    font-size: 1.6rem;
    font-weight: 900;
    color: #fff;
}

.product-link {
    text-decoration: none;
    color: inherit;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-actions {
    margin-top: 20px;
}

.btn-add-cart {
    width: 100%;
    padding: 12px;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-add-cart:hover {
    background: white;
    color: black;
    border-color: white;
}

.btn-add-cart i {
    font-size: 0.8rem;
}
</style>
