<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produk;

class StokNotification extends Component
{
    public $jumlahStokMenipis = 0;

    public function mount()
    {
        $this->jumlahStokMenipis = Produk::where('stok', '<=', 5)->count();
    }

    public function render()
    {
        $this->jumlahStokMenipis = Produk::where('stok', '<=', 5)->count();
        return view('livewire.stok-notification');
    }
}
