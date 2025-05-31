<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterKategori = $request->get('filter_kategori'); // Ambil filter dari request
        $query = DB::table('produk')
            ->join('kategori_produk', 'produk.id_kategori_produk', 'kategori_produk.id_kategori_produk')
            ->orderByDesc('produk.id_produk');

        if ($filterKategori) {
            $query->where('produk.id_kategori_produk', $filterKategori);
        }

        $produk = $query->get();
        $kategori_produk = KategoriProduk::all(); // Ambil data kategori untuk dropdown filter
        $title = 'Data Menu';

        return view('produk.index', compact('produk', 'kategori_produk', 'title'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori_produk = KategoriProduk::all();
        $title = 'Tambah Produk';
        return view('produk.create', compact('kategori_produk', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_produk' => 'required',
            'nama_produk' => 'required',
            'foto_produk' => 'required|image|mimes:gif,png,jpg,jpeg,raw,tiff,ai,psd',
            'harga_produk' => 'required|numeric',
            'deskripsi_produk' => 'required',
            'stok' => 'required|integer|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $foto_produk = $request->file('foto_produk');
        $namafotoproduk = 'FotoProduk' . date('Ymdhis') . '.' . $foto_produk->getClientOriginalExtension();
        $foto_produk->move('file/foto_produk/', $namafotoproduk);



        $produk = new Produk();
        $produk->id_kategori_produk = $request->id_kategori_produk;
        $produk->nama_produk = $request->nama_produk;
        $produk->foto_produk = $namafotoproduk;
        $produk->harga_produk = $request->harga_produk;
        $produk->deskripsi_produk = $request->deskripsi_produk;
        $produk->stok = $request->stok;
        $produk->harga_jual = $request->harga_jual;

        $produk->save();

        return redirect()->route('produk.index')->with('Sukses', 'Berhasil Tambah Produk');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = DB::table('produk')
            ->join('kategori_produk', 'produk.id_kategori_produk', '=', 'kategori_produk.id_kategori_produk')
            ->where('produk.id_produk', $id)
            ->first();

        $title = 'Detail Data Menu';

        return view('produk.show', compact('title', 'produk'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $title = 'Edit Produk';
        $kategori_produk = KategoriProduk::all();
        return view('produk.edit', compact('produk', 'kategori_produk', 'title'));
    }


    public function update(Request $request, Produk $produk)
    {
        $namafotoproduk = $produk->foto_produk;
        $update = [
            'id_kategori_produk' => $request->id_kategori_produk,
            'nama_produk' => $request->nama_produk,
            'foto_produk' => $namafotoproduk,
            'harga_produk' => $request->harga_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'stok' => $request->stok, // Update stok
            'harga_jual' => $request->harga_jual, // Update harga_jual
        ];
        if ($request->foto_produk != "") {
            $request->foto_produk->move('file/foto_produk/', $namafotoproduk);
        }
        $produk->update($update);
        return redirect()->route('produk.index')->with('Sukses', 'Berhasil Edit Produk');
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $namafotoproduk = $produk->foto_produk;
        $foto_produk = ('file/foto_produk/') . $namafotoproduk;
        if (file_exists($foto_produk)) {
            @unlink($foto_produk);
        }
        $produk->delete();
        return redirect()->back()->with('Sukses', 'Berhasil Hapus Produk');
    }
    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
