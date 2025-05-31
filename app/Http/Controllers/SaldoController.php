<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function index(Request $request)
    {
       
        $konf = Setting::first();
        $title = 'Saldo Kas';

        return view('saldo.index', compact('konf','title'));
    }
}
