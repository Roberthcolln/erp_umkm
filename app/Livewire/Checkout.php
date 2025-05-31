<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;

class Checkout extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
    }

    public function processCheckout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kosong');
            return;
        }

        // Validasi stok sebelum proses checkout
        foreach ($this->cart as $item) {
            if ($item['product']->stok < $item['quantity']) {
                session()->flash('error', 'Stok produk "' . $item['product']->nama_produk . '" tidak mencukupi.');
                return; // Batalkan proses checkout
            }
        }

        // Buat order baru
        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'total' => collect($this->cart)->sum(fn($item) => $item['product']->harga_jual * $item['quantity']),
        ]);

        // Simpan item order & kurangi stok produk
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $item['product']->id_produk,
                'harga' => $item['product']->harga_jual,
                'jumlah' => $item['quantity'],
            ]);

            // Kurangi stok produk
            $produk = $item['product'];
            $produk->stok -= $item['quantity'];
            $produk->save();
        }

        // Kosongkan keranjang
        Session::forget('cart');
        $this->cart = [];

        session()->flash('success', 'Pesanan berhasil diproses!');
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
