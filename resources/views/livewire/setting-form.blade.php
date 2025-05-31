<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" wire:click="$set('success', null)" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
                @endif

                <form wire:submit.prevent="save" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Sistem/ Aplikasi</label>
                        <input type="text" wire:model="instansi_setting" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Keyword</label>
                        <input type="text" wire:model="keyword_setting" class="form-control">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="">Tentang Sistem/ Aplikasi</label>
                        <textarea wire:model="tentang_setting" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pimpinan Perusahaan</label>
                        <input type="text" wire:model="pimpinan_setting" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alamat Perusahaan</label>
                        <input type="text" wire:model="alamat_setting" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Youtube</label>
                        <input type="text" wire:model="youtube_setting" class="form-control" placeholder="Masukkan Channel Youtube disini">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Instagram</label>
                        <input type="text" wire:model="instagram_setting" class="form-control" placeholder="Masukkan akun instagram disini...">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" wire:model="email_setting" class="form-control" placeholder="Masukkan email disini">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No. HP</label>
                        <input type="text" wire:model="no_hp_setting" class="form-control" placeholder="Masukkan No HP disini...">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Logo Komunitas</label>
                        <input type="file" wire:model="logo_setting" class="form-control" accept="image/*">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Preview Logo</label>
                        @if ($logo_setting instanceof \Livewire\TemporaryUploadedFile)
                            <img src="{{ $logo_setting->temporaryUrl() }}" style="width: 200px;">
                        @elseif($old_logo)
                            <img src="{{ asset('storage/logo/'.$old_logo) }}" style="width: 200px;">
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Favicon</label>
                        <input type="file" wire:model="favicon_setting" class="form-control" accept="image/*">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Preview Favicon</label>
                        @if ($favicon_setting instanceof \Livewire\TemporaryUploadedFile)
                            <img src="{{ $favicon_setting->temporaryUrl() }}" style="width: 200px;">
                        @elseif($old_favicon)
                            <img src="{{ asset('storage/favicon/'.$old_favicon) }}" style="width: 200px;">
                        @endif
                    </div>

                    <div class="col-12 mb-3">
                        <label>Link Maps</label>
                        <textarea wire:model="maps_setting" class="form-control" rows="3"></textarea>
                    </div>

                    @if ($maps_setting)
                        <iframe class="w-100 rounded" src="{{ $maps_setting }}" frameborder="0" style="min-height: 300px; border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    @endif

                   
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-dark" style="float: right"><i class="fas fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
