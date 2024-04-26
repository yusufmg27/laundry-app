<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 24px; /* Ubah ukuran font menjadi 8px atau sesuai dengan preferensi Anda */
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 14px; /* Ukuran font untuk judul */
            margin: 5px 0;
            text-align: center
        }
        h3 {
            font-size: 12px; /* Ukuran font untuk subjudul */
            margin: 3px 0;
            text-align: center
        }
        p {
            font-size: 10px; /* Ukuran font untuk paragraf */
            margin: 10px 0;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .footer {
            font-size: 9px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Kwitansi Pesanan</h1>
    <h3>Laundry SMKN 1 Ciamis</h3>
    <div class="separator"></div>
    <p><strong>Kode Pesanan:</strong> {{ $order->order_code }}</p>
    <p><strong>Konsumen:</strong> {{ $order->customer->name }}</p>
    <p><strong>Layanan:</strong> {{ $order->service->service_name }}</p>
    <p><strong>Jumlah:</strong> {{ $order->quantity }} kg</p>
    <p><strong>Status Pembayaran:</strong> {{ ucfirst($order->payment_status) }}</p>
    <p><strong>Status Laundry:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total Biaya:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
    <p><strong>Uang Bayar:</strong> Rp {{ number_format($order->payment, 0, ',', '.') }}</p>
    <p><strong>Kembalian:</strong> Rp {{ number_format($order->change, 0, ',', '.') }}</p>
    <div class="separator"></div>
    <p class="footer">Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>
