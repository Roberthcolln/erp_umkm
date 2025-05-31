<?php

namespace App\Http\Controllers;

use App\Livewire\LaporanKeseluruhan;
use App\Models\Order;
use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKeseluruhanController extends Controller
{
    public function index(Request $request)
    {

        $konf = Setting::first();
        $title = 'Data Laporan';

        return view('laporan.index', compact('konf', 'title'));
    }

    public function cetakPDF(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        // Pendapatan
        $orderQuery = Order::where('user_id', Auth::id())->where('status', 'paid');
        if ($start) {
            $orderQuery->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $orderQuery->whereDate('created_at', '<=', $end);
        }
        $totalPendapatan = $orderQuery->sum('total');

        // Pengeluaran
        $pengeluaranQuery = Pengeluaran::query();
        if ($start) {
            $pengeluaranQuery->whereDate('tanggal', '>=', $start);
        }
        if ($end) {
            $pengeluaranQuery->whereDate('tanggal', '<=', $end);
        }
        $totalPengeluaran = $pengeluaranQuery->get()->sum(function ($item) {
            return $item->jumlah * $item->harga_satuan;
        });

        // Stok
        $stokProduk = Produk::with('kategoriProduk')->get();

        $pdf = Pdf::loadView('exports.laporan-keseluruhan', compact(
            'totalPendapatan',
            'totalPengeluaran',
            'stokProduk',
            'start',
            'end'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan_keseluruhan.pdf');
    }

    public function show(LaporanKeseluruhan $laporanKeseluruhan)
    {
        //
    }
}
