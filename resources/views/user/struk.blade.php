<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #facc15;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f3f4f6;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        TOKO BUKU ARBOK<br>
        <small>Struk Pembelian #{{ $transaksi->id }}</small>
    </div>

    <div class="info">
        <p><strong>Nama:</strong> {{ $transaksi->user->name }}</p>
        <p><strong>Alamat:</strong> {{ $transaksi->alamat }}</p>
        <p><strong>Telepon:</strong> {{ $transaksi->telepon }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($transaksi->metode_pembayaran) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->items as $item)
                <tr>
                    <td>{{ $item->produk->nama }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" align="right">Total</td>
                <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Terima kasih telah berbelanja di Toko Buku ReadHaus 📚
    </div>

</body>
</html>
