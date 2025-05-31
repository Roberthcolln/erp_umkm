@extends('layouts.web')
@section('content')

<section class="ftco-section ftco-cart">
  <div class="container">
    @if (session('Sukses'))
    <div class="alert alert-success">{{ session('Sukses') }}</div>
    @endif

    <div class="row">
      <div class="col-md-12 ftco-animate">
        {{-- Tidak perlu form submit, AJAX akan handle update --}}
        <div class="cart-list">
          <table class="table">
            <thead class="thead-primary">
              <tr class="text-center">
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($cart as $id => $item)
              <tr class="text-center">
                <td class="product-remove">
                  <a href="{{ route('cart.remove', $id) }}"><span class="icon-close"></span></a>
                </td>
                <td class="image-prod">
                  <div class="img" style="background-image:url('{{ asset('storage/produk/'.$item['product']->foto_produk) }}');"></div>
                </td>
                <td class="product-name">
                  <h3>{{ $item['product']->nama_produk }}</h3>
                  <p>{{ Str::limit($item['product']->deskripsi_produk, 60) }}</p>
                </td>
                <td class="price">Rp{{ number_format($item['product']->harga_jual, 0, ',', '.') }}</td>
                <td class="quantity">
                  <input
                    type="number"
                    name="quantity[{{ $id }}]"
                    class="form-control input-number quantity-input"
                    value="{{ $item['quantity'] }}"
                    min="1"
                    data-id="{{ $id }}">
                </td>
                <td class="total" id="total-{{ $id }}">
                  Rp{{ number_format($item['product']->harga_jual * $item['quantity'], 0, ',', '.') }}
                </td>

              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">
                  Keranjang Anda kosong.
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if(count($cart))
        <div class="row justify-content-end">
          <div class="col-lg-3 col-md-6 mt-3 cart-wrap ftco-animate">
            <div class="cart-total mb-3">
              <h3>Cart Totals</h3>
              <p class="d-flex">
                <span>Subtotal</span>
                <span id="subtotal">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
              </p>
              <p class="d-flex">
                <span>Delivery</span>
                <span>Rp0</span>
              </p>
              <hr>
              <p class="d-flex total-price">
                <span>Total</span>
                <span id="total">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
              </p>
            </div>

            @if (Auth::check())
            <p class="text-center">
              <a href="{{ route('checkout') }}" class="btn btn-success py-3 px-4">Proceed to Checkout</a>
            </p>
            @else
            <div class="alert alert-warning text-center">
              Harap <a href="{{ route('login') }}">login</a> atau <a href="{{ route('register') }}">register</a> terlebih dahulu untuk melanjutkan ke pembayaran.
            </div>
            @endif

          </div>
        </div>
        @endif

      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.quantity-input').forEach(input => {
  input.addEventListener('change', function() {
    const productId = this.dataset.id;
    let quantity = parseInt(this.value);

    if (quantity < 1 || isNaN(quantity)) {
      quantity = 1;
      this.value = 1;
    }

    fetch("{{ route('cart.update') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        quantity: { [productId]: quantity }
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Update subtotal dan total per item
        document.getElementById('subtotal').innerText = 'Rp' + data.subtotal;
        document.getElementById('total').innerText = 'Rp' + data.subtotal;
        document.getElementById('total-' + productId).innerText = 'Rp' + data.item_total;
      } else {
        alert('Gagal update keranjang');
      }
    })
    .catch(() => alert('Terjadi kesalahan saat update keranjang'));
  });
});
</script>
@endpush
