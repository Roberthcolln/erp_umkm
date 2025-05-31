<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;

class Saldo extends Component
{
    public $totalPendapatan = 0;
    public $totalPengeluaran = 0;
    public $saldo = 0;

    public $tanggalAwal;
    public $tanggalAkhir;

    public function mount()
    {
        // Set default tanggal filter (misal: awal bulan ini sampai hari ini)
        $this->tanggalAwal = now()->startOfMonth()->toDateString();
        $this->tanggalAkhir = now()->toDateString();

        $this->hitungSaldo();
    }

    public function updated($propertyName)
    {
        // Ketika tanggalAwal atau tanggalAkhir berubah, hitung ulang saldo
        if (in_array($propertyName, ['tanggalAwal', 'tanggalAkhir'])) {
            $this->hitungSaldo();
        }
    }

    public function render()
    {
        return view('livewire.saldo');
    }

    public function hitungSaldo()
    {
        $queryPendapatan = Order::where('status', 'paid')
            ->where('user_id', Auth::id());

        $queryPengeluaran = Pengeluaran::query();

        // Filter tanggal jika ada dan valid
        if ($this->tanggalAwal && $this->tanggalAkhir) {
            // Pastikan tanggalAwal <= tanggalAkhir
            if ($this->tanggalAwal <= $this->tanggalAkhir) {
                $queryPendapatan->whereBetween('created_at', [$this->tanggalAwal . ' 00:00:00', $this->tanggalAkhir . ' 23:59:59']);
                $queryPengeluaran->whereBetween('created_at', [$this->tanggalAwal . ' 00:00:00', $this->tanggalAkhir . ' 23:59:59']);
            }
        }

        $this->totalPendapatan = $queryPendapatan->sum('total');
        $this->totalPengeluaran = $queryPengeluaran->sum('total_harga');

        $this->saldo = $this->totalPendapatan - $this->totalPengeluaran;
    }
}
