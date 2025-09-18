<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian - Seilmu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
            color: #1e293b;
        }
        .receipt {
            max-width: 750px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 2px solid #e2e8f0;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }
        .header h2 {
            margin: 0;
            color: #1e40af;
            font-size: 28px;
        }
        .header small {
            color: #64748b;
            font-size: 14px;
        }
        .info {
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
            border-radius: 6px;
        }
        .info p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        table thead {
            background: #1e40af;
            color: #fff;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
            vertical-align: middle;
        }
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
        }
        .total-row td {
            font-weight: bold;
            color: #1e40af;
            background: #e0f2fe;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #475569;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #94a3b8;
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
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->items as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                 alt="{{ $item->produk->nama }}"
                                 class="product-img">
                        </td>
                        <td>{{ $item->produk->nama }}</td>
                        <td>{{ $item->produk->kategori->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5" align="right">Total</td>
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
