<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
</head>
<body>

    <div>
        TOKO BUKU ARBOK<br>
        <small>Struk Pembelian #{{ $transaksi->id }}</small>
    </div>

    <div>
        <p>Nama: {{ $transaksi->user->name }}</p>
        <p>Alamat: {{ $transaksi->alamat }}</p>
        <p>Telepon: {{ $transaksi->telepon }}</p>
        <p>Status: {{ ucfirst($transaksi->status) }}</p>
        <p>Metode Pembayaran: {{ ucfirst($transaksi->metode_pembayaran) }}</p>
    </div>

    <table border="1" cellspacing="0" cellpadding="5">
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
            <tr>
                <td colspan="3" align="right">Total</td>
                <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div>
        Terima kasih telah berbelanja di Toko Buku ReadHaus
    </div>

</body>
</html>
