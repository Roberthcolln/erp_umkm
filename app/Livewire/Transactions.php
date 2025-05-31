<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Transactions extends Component
{
    public $jumlahBayar = [];
    public $kembalian = [];
    public $totalPendapatan = 0;
    public $startDate;
    public $endDate;

    public function render()
    {
        $orders = $this->getFilteredOrders();

        // Hitung total pendapatan hanya dari transaksi yang "paid"
        $this->totalPendapatan = $orders->where('status', 'paid')->sum('total');

        return view('livewire.transactions', [
            'orders' => $orders,
        ]);
    }

    public function filterTanggal()
    {
        // Tidak perlu isi apa-apa, cukup trigger re-render
    }

    protected function getFilteredOrders()
    {
        $query = Order::with('items.produk', 'user')
            ->where('user_id', Auth::id());

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->latest()->get();
    }

    public function updatedJumlahBayar($value, $key)
    {
        $order = Order::find($key);
        if ($order) {
            $this->kembalian[$key] = max(0, $value - $order->total);
        }
    }

    public function bayar($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if ($order && $order->status === 'pending') {
            $bayar = $this->jumlahBayar[$orderId] ?? 0;

            if ($bayar < $order->total) {
                session()->flash('error', 'Jumlah bayar kurang dari total.');
                return;
            }

            $kembalian = $bayar - $order->total;

            $order->update([
                'status' => 'paid',
                'jumlah_bayar' => $bayar,
                'kembalian' => $kembalian,
            ]);

            $this->reset(['jumlahBayar', 'kembalian']);
            session()->flash('message', 'Pembayaran berhasil!');
        }
    }

    public function resetFilter()
    {
        $this->reset(['startDate', 'endDate']);
    }
}
