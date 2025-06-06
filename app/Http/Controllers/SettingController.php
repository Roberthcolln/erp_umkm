<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Setting';
        $setting = Setting::first();
        return view('setting.index', compact('setting', 'title'));
    }


    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        // Simpan nama file lama
        $logo = $setting->logo_setting;
        $background = $setting->background_setting;
        $favicon = $setting->favicon_setting;
        $bg = $setting->bg_tentang_setting;

        // Periksa dan unggah file baru jika ada
        if ($request->hasFile('logo_setting')) {
            // Hapus logo lama jika ada
            if ($logo && file_exists(public_path('logo/' . $logo))) {
                unlink(public_path('logo/' . $logo));
            }
            $logoFile = $request->file('logo_setting');
            $logo = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move('logo/', $logo);
        }

        if ($request->hasFile('favicon_setting')) {
            if ($favicon && file_exists(public_path('favicon/' . $favicon))) {
                unlink(public_path('favicon/' . $favicon));
            }
            $faviconFile = $request->file('favicon_setting');
            $favicon = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
            $faviconFile->move('favicon/', $favicon);
        }

        if ($request->hasFile('background_setting')) {
            if ($background && file_exists(public_path('background/' . $background))) {
                unlink(public_path('background/' . $background));
            }
            $backgroundFile = $request->file('background_setting');
            $background = 'background_' . time() . '.' . $backgroundFile->getClientOriginalExtension();
            $backgroundFile->move('background/', $background);
        }

        if ($request->hasFile('bg_tentang_setting')) {
            if ($bg && file_exists(public_path('background_setting/' . $bg))) {
                unlink(public_path('background_setting/' . $bg));
            }
            $bgFile = $request->file('bg_tentang_setting');
            $bg = 'bg_tentang_' . time() . '.' . $bgFile->getClientOriginalExtension();
            $bgFile->move('background_setting/', $bg);
        }

        // Update data di database
        $setting->update([
            'instansi_setting' => $request->instansi_setting,
            'pimpinan_setting' => $request->pimpinan_setting,
            'logo_setting' => $logo,
            'favicon_setting' => $favicon,
            'tentang_setting' => $request->tentang_setting,
            'keyword_setting' => $request->keyword_setting,
            'alamat_setting' => $request->alamat_setting,
            'instagram_setting' => $request->instagram_setting,
            'youtube_setting' => $request->youtube_setting,
            'email_setting' => $request->email_setting,
            'no_hp_setting' => $request->no_hp_setting,
            'maps_setting' => $request->maps_setting,
            'background_setting' => $background,
            'bg_tentang_setting' => $bg,
        ]);

        return redirect()->back()->with('Sukses', 'Berhasil Update Konfigurasi Website');
    }




    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
