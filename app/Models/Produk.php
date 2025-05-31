<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'id_kategori_produk',
        'nama_produk',
        'slug_produk', // <--- tambahkan ini
        'foto_produk',
        'harga_produk',
        'deskripsi_produk',
        'stok',
        'harga_jual',
    ];


    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class, 'id_kategori_produk', 'id_kategori_produk');
    }
}
