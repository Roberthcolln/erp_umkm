<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = ['nama_barang', 'jumlah', 'harga_satuan', 'keterangan', 'tanggal'];

    protected $appends = ['total_harga'];

    public function getTotalHargaAttribute()
    {
        return $this->jumlah * $this->harga_satuan;
    }
}
