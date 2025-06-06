<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;
    protected $table = 'kategori_produk';
    protected $primaryKey = 'id_kategori_produk';
    protected $fillable = [
        'nama_kategori_produk',

    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori_produk', 'id_kategori_produk');
    }
}
