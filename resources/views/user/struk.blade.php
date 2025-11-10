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
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
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
            font-size: 24px;
        }
        .header small {
            color: #64748b;
            font-size: 13px;
        }
        .info {
            margin-bottom: 12px;
            padding: 8px 12px;
            background: #f8fafc;
            border-left: 3px solid #3b82f6;
            border-radius: 4px;
        }
        .info p {
            margin: 4px 0;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 12px;
            font-size: 13px;
        }
        table thead {
            background: #1e40af;
            color: #fff;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 6px;
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
            font-size: 12px;
            color: #475569;
            margin-top: 20px;
            padding-top: 12px;
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
