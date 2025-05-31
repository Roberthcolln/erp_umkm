<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::with(['produk' => function ($q) {
            $q->orderBy('nama_produk');
        }])->get();


        return view('welcome', compact('kategori'));
    }


    public function detailProduk($slug)
    {
        $produk = Produk::where('slug_produk', $slug)->firstOrFail();
        return view('produk.detail', compact('produk'));
    }
}
