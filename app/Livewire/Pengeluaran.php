<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengeluaran as PengeluaranModel;

class Pengeluaran extends Component
{
    public $tanggal, $nama_barang, $jumlah, $harga_satuan, $keterangan;
    public $pengeluarans;
    public $filterTanggalAwal, $filterTanggalAkhir;
    public $editId = null;

    public function mount()
    {
        $this->loadPengeluaran();
    }

    public function render()
    {
        return view('livewire.pengeluaran');
    }

    // Simpan data, bisa untuk create atau update
    public function simpan()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        if ($this->editId) {
            // Update data
            $pengeluaran = PengeluaranModel::findOrFail($this->editId);
            $pengeluaran->update([
                'tanggal' => $this->tanggal,
                'nama_barang' => $this->nama_barang,
                'jumlah' => $this->jumlah,
                'harga_satuan' => $this->harga_satuan,
                'keterangan' => $this->keterangan,
            ]);
            session()->flash('success', 'Pengeluaran berhasil diperbarui.');
        } else {
            // Create data baru
            PengeluaranModel::create([
                'tanggal' => $this->tanggal,
                'nama_barang' => $this->nama_barang,
                'jumlah' => $this->jumlah,
                'harga_satuan' => $this->harga_satuan,
                'keterangan' => $this->keterangan,
            ]);
            session()->flash('success', 'Pengeluaran berhasil disimpan.');
        }

        // Reset form dan data edit
        $this->reset(['tanggal', 'nama_barang', 'jumlah', 'harga_satuan', 'keterangan', 'editId']);

        // Refresh data list sesuai filter yang aktif
        $this->loadPengeluaran();
    }

    // Mengisi form untuk edit
    public function edit($id)
    {
        $pengeluaran = PengeluaranModel::findOrFail($id);

        $this->editId = $id;
        $this->tanggal = $pengeluaran->tanggal;
        $this->nama_barang = $pengeluaran->nama_barang;
        $this->jumlah = $pengeluaran->jumlah;
        $this->harga_satuan = $pengeluaran->harga_satuan;
        $this->keterangan = $pengeluaran->keterangan;
    }

    // Hapus data
    public function hapus($id)
    {
        PengeluaranModel::findOrFail($id)->delete();

        session()->flash('success', 'Pengeluaran berhasil dihapus.');

        // Refresh data list sesuai filter yang aktif
        $this->loadPengeluaran();
    }

    // Method ini harus public supaya bisa dipanggil dari Blade
    public function loadPengeluaran()
    {
        $query = PengeluaranModel::query();

        if ($this->filterTanggalAwal) {
            $query->whereDate('tanggal', '>=', $this->filterTanggalAwal);
        }
        if ($this->filterTanggalAkhir) {
            $query->whereDate('tanggal', '<=', $this->filterTanggalAkhir);
        }

        $this->pengeluarans = $query->latest()->get();
    }

    // Method dipanggil dari tombol filter di view
    public function filterData()
    {
        $this->loadPengeluaran();
    }

    // Reset filter dan tampilkan semua data
    public function resetFilter()
    {
        $this->reset(['filterTanggalAwal', 'filterTanggalAkhir']);
        $this->loadPengeluaran();
    }
}
