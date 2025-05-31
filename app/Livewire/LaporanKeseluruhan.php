<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Pengeluaran;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class LaporanKeseluruhan extends Component
{
    public $startDate;
    public $endDate;

    public $totalPendapatan = 0;
    public $totalPengeluaran = 0;
    public $stokProduk = [];

    public function render()
    {
        $this->hitungTotal();

        return view('livewire.laporan-keseluruhan', [
            'stokProduk' => $this->stokProduk
        ]);
    }

    public function hitungTotal()
    {
        // Transaksi
        $orderQuery = Order::where('user_id', Auth::id())->where('status', 'paid');
        if ($this->startDate) {
            $orderQuery->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $orderQuery->whereDate('created_at', '<=', $this->endDate);
        }
        $this->totalPendapatan = $orderQuery->sum('total');

        // Pengeluaran
        $pengeluaranQuery = Pengeluaran::query();
        if ($this->startDate) {
            $pengeluaranQuery->whereDate('tanggal', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $pengeluaranQuery->whereDate('tanggal', '<=', $this->endDate);
        }
        $this->totalPengeluaran = $pengeluaranQuery->get()->sum(function ($item) {
            return $item->jumlah * $item->harga_satuan;
        });

        // Stok Produk (tanpa filter tanggal)
        $this->stokProduk = Produk::with('kategoriProduk')->get();
    }

    public function resetFilter()
    {
        $this->reset(['startDate', 'endDate']);
    }
}
