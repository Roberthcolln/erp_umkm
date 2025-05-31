<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body { 
            font-family: monospace;
            font-size: 14px;
            margin: 20px;
        }
        .text-center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 4px 6px; text-align: left; }
        th { border-bottom: 1px solid #000; }
        hr { border: 0; border-top: 1px dashed #000; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="text-center">
        <h3>STRUK PEMBAYARAN</h3>
        <p>ID Order: {{ $order->id }}</p>
        <p>Tanggal: {{ $order->created_at->format('d-m-Y H:i') }}</p>
        <p>Kasir: {{ $order->user->name ?? 'Guest' }}</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>@ {{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td><strong>Total</strong></td>
            <td class="text-right">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Bayar (Cash)</strong></td>
            <td class="text-right">Rp{{ number_format($order->jumlah_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Kembali</strong></td>
            <td class="text-right">Rp{{ number_format($order->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <hr>
    <p class="text-center">Terima kasih atas kunjungan Anda!</p>

    <script>
        window.print();
    </script>
</body>
</html>
