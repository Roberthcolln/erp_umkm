<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keseluruhan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Laporan Keseluruhan</h3>
    <p>Periode: {{ $start ?? '-' }} s/d {{ $end ?? '-' }}</p>

    <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
    <p><strong>Keuntungan Bersih:</strong> Rp {{ number_format($totalPendapatan - $totalPengeluaran, 0, ',', '.') }}</p>

    <h4>Stok Produk</h4>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stokProduk as $produk)
                <tr>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->kategoriProduk->nama_kategori_produk ?? '-' }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
