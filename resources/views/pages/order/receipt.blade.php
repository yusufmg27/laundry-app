<!DOCTYPE html>
<html>
<head>
    <title>Kwitansi Pesanan</title>
    <style>
        /* CSS styling for your receipt */
    </style>
</head>
<body>
    <h1>Kwitansi Pesanan Laundry SMKN 1 Ciamis</h1>
    <p><strong>Kode Pesanan:</strong> {{ $order->order_code }}</p>
    <p><strong>Jumlah:</strong> {{ $order->quantity }} kg</p>
    <p><strong>Status Pembayaran:</strong> {{ $order->payment_status }}</p>
    <p><strong>Status Laundry:</strong> {{ $order->status }}</p>
    <p><strong>Bayar:</strong> {{ $order->payment }}</p>
    <p><strong>Kembalian:</strong> {{ $order->change }}</p>
    <p><strong>Total:</strong> {{ $order->total }}</p>
</body>
</html>
