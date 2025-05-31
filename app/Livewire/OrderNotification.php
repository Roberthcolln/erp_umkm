<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderNotification extends Component
{
    public $newPesanCount;

    public function mount()
    {
        // Inisialisasi jumlah pemesanan pending saat pertama kali komponen dimuat
        $this->newPesanCount = Order::where('status', 'pending')->count();
    }

    public function render()
    {
        // Setiap kali render, update jumlah pemesanan pending
        $this->newPesanCount = Order::where('status', 'pending')->count();
        
         return view('livewire.order-notification');
    }
}

