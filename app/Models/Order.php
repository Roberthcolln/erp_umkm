<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Izinkan mass assignment untuk kolom-kolom ini
    protected $fillable = [
        'user_id',
        'total',
        'status', // tambahkan ini
        'jumlah_bayar', // tambahkan ini
        'kembalian', // tambahkan ini
    ];

    // (Opsional) Relasi ke item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
