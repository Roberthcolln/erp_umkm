<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Klinik;
use App\Models\Setting;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $konf = Setting::first();
        $title = 'Dashboard';

        return view('dashboard.index', compact('konf','title'));
    }
    

    
    
}
