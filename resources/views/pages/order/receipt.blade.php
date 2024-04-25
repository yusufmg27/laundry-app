<!DOCTYPE html>
<html>
<head>
    <title>Kwitansi Pesanan</title>
    <style>
        /* CSS styling for your receipt */
    </style>
</head>
<body>
    <h1>Kwitansi Pesanan</h1>
    <h3>Laundry SMKN 1 Ciamis</h3>
    <p><strong>Kode Pesanan:</strong> {{ $order->order_code }}</p>
    <p><strong>Konsumen:</strong> {{ $order->customer->name }}</p>
    <p><strong>Layanan:</strong> {{ $order->service->service_name }}</p>
    <p><strong>Jumlah:</strong> {{ $order->quantity }} kg</p>
    <p><strong>Status Pembayaran:</strong> {{ ucfirst($order->payment_status) }}</p>
    <p><strong>Status Laundry:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total Biaya:</strong> {{ $order->total }}</p>
    <p><strong>Uang Bayar:</strong> {{ $order->payment }}</p>
    <p><strong>Kembalian:</strong> {{ $order->change }}</p>
</body>
</html>
