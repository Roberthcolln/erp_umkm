<div>
    <section class="ftco-section ftco-cart py-5">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Ringkasan Checkout</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="processCheckout">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th>Produk</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
    @php
        $grandTotal = 0;
    @endphp

    @forelse ($cart as $item)
        @php
            $itemTotal = $item['product']->harga_jual * $item['quantity'];
            $grandTotal += $itemTotal;
        @endphp
        <tr class="text-center align-middle">
            <td>{{ $item['product']->nama_produk }}</td>
            <td>Rp{{ number_format($item['product']->harga_jual, 0, ',', '.') }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>Rp{{ number_format($itemTotal, 0, ',', '.') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">Keranjang kosong</td>
        </tr>
    @endforelse

    @if (!empty($cart))
        <tr class="font-weight-bold text-right">
            <td colspan="3" class="text-right pr-3"><strong>Total Bayar:</strong></td>
            <td class="text-center"><strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
        </tr>
    @endif
</tbody>

                                    </table>
                                </div>

                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-success btn-lg px-4">
                                        <i class="fa fa-credit-card mr-1"></i> Pesan Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
