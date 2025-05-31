<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KategoriProduk;

class ProdukList extends Component
{
    public $kategori;

    public function mount()
    {
        $this->loadKategori();
    }

    public function loadKategori()
    {
        // Load kategori beserta produk
        $this->kategori = KategoriProduk::with(['produk' => function ($q) {
            $q->orderBy('nama_produk');
        }])->get();
    }

    protected $listeners = ['produkUpdated' => 'loadKategori'];

    public function render()
    {
        return view('livewire.produk-list');
    }
}
