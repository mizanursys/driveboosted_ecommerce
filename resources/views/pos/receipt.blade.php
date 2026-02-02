<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        @page { size: 80mm 200mm; margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 14px; 
            width: 72mm; 
            margin: 0 auto;
            padding: 5mm;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; border-bottom: 1px solid #000; }
        .footer { font-size: 12px; margin-top: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print mb-2 text-center">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print Receipt</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Close</button>
    </div>

    <div class="text-center">
        <h2 class="bold mb-1">DRIVE BOOSTED</h2>
        <p class="mb-1">Premium Detailing Showroom</p>
        <p class="mb-2">Dhaka, Bangladesh</p>
        <p class="mb-1">Phone: +880 1612 770066</p>
    </div>

    <div class="divider"></div>

    <p class="mb-1">Order #: {{ $order->order_number }}</p>
    <p class="mb-1">Date: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p class="mb-1">Cashier: {{ $order->user->name }}</p>
    @if($order->customer_name)
    <p class="mb-1">Customer: {{ $order->customer_name }}</p>
    @endif

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td style="max-width: 30mm;">{{ $item->product_name }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->price) }}</td>
                <td class="text-right">{{ number_format($item->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="text-right">
        <p class="mb-1">Subtotal: ৳{{ number_format($order->subtotal) }}</p>
        @if($order->discount_amount > 0)
        <p class="mb-1">Discount: -৳{{ number_format($order->discount_amount) }}</p>
        @endif
        <h3 class="bold">Total: ৳{{ number_format($order->total) }}</h3>
    </div>

    <div class="divider"></div>

    <div class="text-center">
        <p class="mb-1">Payment: {{ strtoupper($order->payment_method) }}</p>
        <p class="mb-1">Paid: ৳{{ number_format($order->paid_amount) }}</p>
        <p class="mb-1">Change: ৳{{ number_format($order->change_amount) }}</p>
    </div>

    <div class="divider"></div>

    <div class="footer text-center">
        <p class="bold">Thank you for your visit!</p>
        <p>Visit: driveboosted.com</p>
        <p>Software by Antigravity AI</p>
    </div>

    <script>
        // Auto print on load if not previewing
        window.onload = function() {
            // window.print();
        }
    </script>
</body>
</html>
