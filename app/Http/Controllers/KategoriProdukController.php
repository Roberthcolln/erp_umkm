<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kategori Produk';
        $kategori_produk = DB::table('kategori_produk')->orderByDesc('id_kategori_produk')->get();
        return view('kategori_produk.index', compact('title', 'kategori_produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kategori Produk';
        return view('kategori_produk.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' =>'Atribut Wajib Diisi',
        ];
        $request->validate([
            'nama_kategori_produk' => 'required',
            
        ], $messages);
        KategoriProduk::create($request->all());
        return redirect()->route('kategori_produk.index')->with('Sukses', 'Berhasil Tambah Kategori Produk');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProduk $kategoriProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori_produk = KategoriProduk::find($id);
        $title = 'Edit Kategori Produk';
        return view('kategori_produk.edit', compact('kategori_produk', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' =>'Atribut Wajib Diisi',
        ];
        $request->validate([
            'nama_kategori_produk' => 'required',
            
        ], $messages);
        $kategori_produk = KategoriProduk::findorfail($id);
        $kategori_produk->update($request->all());
        return redirect()->route('kategori_produk.index')->with('Sukses', 'Berhasil Edit Kategori Produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori_produk = KategoriProduk::find($id);
        $kategori_produk->delete();
        return redirect()->back()->with('Sukses', 'Berhasil Hapus Kategori Produk');
    }
}
