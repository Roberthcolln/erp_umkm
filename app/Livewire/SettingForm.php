<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingForm extends Component
{
    use WithFileUploads;

    public $setting;

    public $instansi_setting, $pimpinan_setting, $logo_setting, $favicon_setting,
        $tentang_setting, $keyword_setting, $alamat_setting, $instagram_setting,
        $youtube_setting, $email_setting, $no_hp_setting, $maps_setting,
        $bg_tentang_setting;

    // Untuk menyimpan nama file lama (digunakan fallback jika tidak upload ulang)
    public $old_logo, $old_favicon;

    public $title = 'Konfigurasi Aplikasi';

    public function mount()
    {
        $this->setting = Setting::first();

        foreach ($this->setting->getAttributes() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        // Simpan nama file lama
        $this->old_logo = $this->setting->logo_setting;
        $this->old_favicon = $this->setting->favicon_setting;

        // Kosongkan properti file upload (agar bisa pakai `temporaryUrl()`)
        $this->logo_setting = null;
        $this->favicon_setting = null;
    }

    public function save()
    {
        // Validasi input
        $validated = $this->validate([
            'instansi_setting'     => 'required|string',
            'pimpinan_setting'     => 'nullable|string',
            'tentang_setting'      => 'nullable|string',
            'keyword_setting'      => 'nullable|string',
            'alamat_setting'       => 'nullable|string',
            'instagram_setting'    => 'nullable|string',
            'youtube_setting'      => 'nullable|string',
            'email_setting'        => 'nullable|email',
            'no_hp_setting'        => 'nullable|string',
            'maps_setting'         => 'nullable|string',
            'logo_setting'         => 'nullable|image|max:1024',   // 1MB
            'favicon_setting'      => 'nullable|image|max:512',    // 512KB
        ]);

        // Default: gunakan file lama jika tidak upload baru
        $validated['logo_setting'] = $this->old_logo;
        $validated['favicon_setting'] = $this->old_favicon;

        // Simpan logo baru jika diupload
        if ($this->logo_setting) {
            // Hapus file lama
            if ($this->old_logo && Storage::disk('public')->exists('logo/' . $this->old_logo)) {
                Storage::disk('public')->delete('logo/' . $this->old_logo);
            }

            $filename = uniqid('logo_') . '.' . $this->logo_setting->getClientOriginalExtension();
            $this->logo_setting->storeAs('logo', $filename, 'public');
            $validated['logo_setting'] = $filename;
        }

        // Simpan favicon baru jika diupload
        if ($this->favicon_setting) {
            if ($this->old_favicon && Storage::disk('public')->exists('favicon/' . $this->old_favicon)) {
                Storage::disk('public')->delete('favicon/' . $this->old_favicon);
            }

            $filename = uniqid('favicon_') . '.' . $this->favicon_setting->getClientOriginalExtension();
            $this->favicon_setting->storeAs('favicon', $filename, 'public');
            $validated['favicon_setting'] = $filename;
        }

        // Simpan ke database
        $this->setting->update($validated);

        // Refresh nilai lama
        $this->old_logo = $validated['logo_setting'];
        $this->old_favicon = $validated['favicon_setting'];

        session()->flash('success', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.setting-form');
    }
}
