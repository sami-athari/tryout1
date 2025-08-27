<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian - Seilmu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 20px;
            color: #1e293b;
        }
        .receipt {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #1e40af;
        }
        .header small {
            color: #64748b;
        }
        .info p {
            margin: 3px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        table thead {
            background: #1e40af;
            color: #fff;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        table tbody tr:nth-child(even) {
            background: #f1f5f9;
        }
        .total-row td {
            font-weight: bold;
            color: #1e40af;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #475569;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="receipt">
        <div class="header">
            <h2>📚 Seilmu Bookstore</h2>
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
            <p>✨ Terima kasih telah berbelanja di <strong>Seilmu</strong>. Sampai jumpa lagi! ✨</p>
        </div>
    </div>

</body>
</html>
