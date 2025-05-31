<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Tampilkan halaman cart
    public function index()
    {
        $cart = session()->get('cart', []);
        // Hitung subtotal
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['product']->harga_jual * $item['quantity'];
        });
        return view('cart.index', compact('cart', 'subtotal'));
    }

    // Tambah produk ke cart berdasarkan slug
    public function add($slug)
    {
        $product = Produk::where('slug_produk', $slug)->firstOrFail();
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id_produk])) {
            $cart[$product->id_produk]['quantity']++;
        } else {
            $cart[$product->id_produk] = [
                'product'  => $product,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('Sukses', 'Produk ditambahkan ke keranjang.');
    }

    // Update kuantitas di cart
    public function update(Request $request)
    {
        $quantities = $request->input('quantity', []);
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, intval($qty));
            }
        }

        session()->put('cart', $cart);

        // Hitung subtotal & total item
        foreach ($cart as $id => $item) {
            $subtotal += $item['product']->harga_jual * $item['quantity'];
        }

        // Ambil satu item yang diubah
        $product_id = array_key_first($quantities);
        $item_total = $cart[$product_id]['product']->harga_jual * $cart[$product_id]['quantity'];

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'item_total' => number_format($item_total, 0, ',', '.'),
            'product_id' => $product_id,
        ]);
    }


    // Hapus item dari cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('Sukses', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        return view('cart.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong');
        }

        // Simpan Order
        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'total' => collect($cart)->sum(fn($item) => $item['product']->harga_jual * $item['quantity']),
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $item['product']->id_produk,
                'harga' => $item['product']->harga_jual,
                'jumlah' => $item['quantity'],
            ]);
        }


        Session::forget('cart'); // Kosongkan keranjang

        return redirect()->route('home')->with('success', 'Pesanan berhasil diproses!');
    }

    public function transactions()
    {
        $title = 'Transaction';
        return view('cart.transactions', compact('title'));
    }

    public function cetakStruk(Order $order)
    {
        $order->load('items.produk', 'user');
        return view('struk', compact('order'));
    }
}
