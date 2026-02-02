@if(session('cart') && count(session('cart')) > 0)
    @foreach(session('cart') as $id => $details)
        <div class="drawer-item">
            <img src="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset('storage/' . $details['image']) }}" 
                 alt="{{ $details['name'] }}"
                 loading="lazy"
                 decoding="async">
            <div class="item-info flex-grow-1">
                <div class="fs-7 fw-800 text-primary mb-1 ls-narrow">{{ $details['name'] }}</div>
                <div class="fs-8 fw-900 text-muted">৳{{ number_format($details['price']) }} × {{ $details['quantity'] }}</div>
            </div>
            <div class="item-remove">
                <form action="{{ route('cart.remove') }}" method="POST" class="ajax-cart-remove-form">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $id }}">
                    <button type="submit" class="nav-icon fs-7 opacity-30"><i class="fas fa-times"></i></button>
                </form>
            </div>
        </div>
    @endforeach
@else
    <div class="py-5 text-center">
        <i class="fas fa-shopping-bag opacity-10 display-3 mb-4 d-block"></i>
        <p class="fs-7 fw-900 ls-2 opacity-30 m-0">YOUR GEAR BAG IS EMPTY</p>
    </div>
@endif
