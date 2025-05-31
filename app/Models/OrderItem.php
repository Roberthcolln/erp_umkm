<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'produk_id',
        'harga',
        'jumlah',
    ];

    // (Opsional) Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // (Opsional) Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }
}
