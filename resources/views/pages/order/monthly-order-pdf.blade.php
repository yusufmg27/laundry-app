<!DOCTYPE html>
<html>
<head>
    <title>Laporan Order Laundry SMKN 1 Ciamis</title>
    <style>
        /* CSS styling for your monthly report */
        table {
            width: 100%; /* Mengatur lebar tabel menjadi 100% dari lebar kontainer */
            border-collapse: collapse; /* Menggabungkan batas sel */
            border: 1px solid black;
        }

        th, td {
            padding: 8px; /* Mengatur padding untuk sel */
            text-align: left; /* Mengatur teks menjadi rata kiri */
            border-bottom: 1px solid #ddd; /* Menambahkan garis bawah pada sel */
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2; /* Memberikan warna latar belakang untuk sel header */
        }

        tbody tr:last-child td {
            border-bottom: none; /* Menghilangkan garis bawah pada baris terakhir */
        }
    </style>
</head>
<body>
    <h1>Laporan Order Bulanan</h1>
    <h2>Bulan: 
        <?php
        // Mengonversi angka bulan menjadi nama bulan
        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        echo $monthName;
        ?>
    </h2>
    <h2>Tahun: {{ $year }}</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Layanan</th>
                <th>Jumlah</th>
                <th>Status Pembayaran</th>
                <th>Status Laundry</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->created_at->format('d F Y') }}</td> <!-- Tambahkan kolom tanggal dengan format "tanggal bulan tahun" -->
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->service->service_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ ucfirst($order->payment_status) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
