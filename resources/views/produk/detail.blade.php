@extends('layouts.web')
@section('content')



<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="{{ asset('storage/produk/' . $produk->foto_produk) }}" class="image-popup">
                    <img src="{{ asset('storage/produk/' . $produk->foto_produk) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                </a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3>{{ $produk->nama_produk }}</h3>
                <p class="price">
                    <span>Rp{{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                </p>
                <p>{{ $produk->deskripsi_produk }}</p>

                
                <p>
                    <a href="{{ route('cart.add', $produk->slug_produk) }}"
                        class="btn btn-primary py-3 px-5">
                        Add to Cart
                    </a>
                </p>

            </div>
        </div>
    </div>
</section>

@endsection