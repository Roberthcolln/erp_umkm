@extends('layouts.web')
@section('content')

<section class="ftco-menu">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 heading-section text-center ftco-animate">
                <span class="subheading">Discover</span>
                <h2 class="mb-4">Our Products</h2>
                <p>Explore our carefully crafted selections from the best ingredients.</p>
            </div>
        </div>

        <div class="row d-md-flex">
            <div class="col-lg-12 ftco-animate p-md-5">
                <div class="row">
                    <!-- Tabs -->
                    <div class="col-md-12 nav-link-wrap mb-4">
                        <div class="nav nav-pills justify-content-center" id="v-pills-tab" role="tablist">
                            @foreach ($kategori as $key => $kat)
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="v-pills-{{ $key }}-tab"
                                    data-toggle="pill"
                                    href="#v-pills-{{ $key }}"
                                    role="tab"
                                    aria-controls="v-pills-{{ $key }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $kat->nama_kategori_produk }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="col-md-12">
                        <div class="tab-content ftco-animate" id="v-pills-tabContent">
                            @foreach ($kategori as $key => $kat)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="v-pills-{{ $key }}"
                                    role="tabpanel"
                                    aria-labelledby="v-pills-{{ $key }}-tab">
                                    <div class="row">
                                        @forelse ($kat->produk as $item)
                                            <div class="col-md-4 mb-5 text-center">
                                                <div class="menu-wrap shadow-sm p-3 rounded h-100 d-flex flex-column justify-content-between">
                                                    <a href="#" class="menu-img img mb-3"
                                                        style="background-image: url('{{ $item->foto_produk ? asset('storage/produk/'.$item->foto_produk) : asset('images/default.png') }}'); height: 200px; background-size: cover; background-position: center;"></a>
                                                    <div class="text">
                                                        <h4><a href="#" class="text-dark">{{ $item->nama_produk }}</a></h4>
                                                        <p class="mb-2 text-muted">{{ Str::limit($item->deskripsi_produk, 80) }}</p>

                                                        <p class="price font-weight-bold text-primary mb-2">
                                                            Rp{{ number_format($item->harga_jual, 0, ',', '.') }}
                                                        </p>

                                                        @if($item->stok == 0)
                                                            <p class="text-danger font-weight-bold mb-2">
                                                                Stok: Habis
                                                            </p>
                                                        @elseif($item->stok < 5)
                                                            <p class="text-warning font-weight-bold mb-2">
                                                                Stok: {{ $item->stok }} (Stok Hampir Habis!)
                                                            </p>
                                                        @else
                                                            <p class="text-success font-weight-bold mb-2">
                                                                Stok: {{ $item->stok }}
                                                            </p>
                                                        @endif

                                                        <a href="{{ route('produk.detail', $item->slug_produk) }}" class="btn btn-sm btn-outline-primary px-3">
                                                            View Detail
                                                        </a>

                                                        <a href="{{ route('cart.add', $item->slug_produk) }}"
                                                            class="btn btn-sm btn-outline-primary px-3
                                                            {{ $item->stok == 0 ? 'disabled' : '' }}"
                                                            {{ $item->stok == 0 ? 'aria-disabled=true tabindex=-1' : '' }}>
                                                            Add Cart
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center">
                                                <p class="text-muted">Produk belum tersedia di kategori ini.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div> <!-- row -->
            </div>
        </div>
    </div>
</section>

@endsection
