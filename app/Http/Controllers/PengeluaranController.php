<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
       
        $konf = Setting::first();
        $title = 'Pengeluaran';

        return view('pengeluaran.index', compact('konf','title'));
    }
}
