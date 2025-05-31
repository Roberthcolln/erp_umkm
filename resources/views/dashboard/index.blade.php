@extends('layouts.index')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0"><i class="fas fa-building"></i> Tentang Perusahaan</h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Logo Perusahaan -->
                        <div class="col-md-4 text-center animate__animated animate__zoomIn">
                            @if($konf->logo_setting)
                                <img src="{{ asset('storage/logo/'.$konf->logo_setting) }}" class="img-fluid" style="max-width: 200px;" alt="Logo Perusahaan">
                            @endif
                        </div>
                        <!-- Deskripsi Perusahaan -->
                        <div class="col-md-8 animate__animated animate__fadeInRight">
                            <h4 class="fw-bold">{{ $konf->instansi_setting }}</h4>
                            <p class="text-muted"><i class="fas fa-user-tie"></i> Pimpinan: <strong>{{ $konf->pimpinan_setting }}</strong></p>
                            <p>{{ $konf->tentang_setting }}</p>
                            <div class="mt-3">
                                <a href="mailto:{{ $konf->email_setting }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-envelope"></i> Email</a>
                                <a href="{{ $konf->instagram_setting }}" class="btn btn-sm btn-outline-danger" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                                <a href="{{ $konf->youtube_setting }}" class="btn btn-sm btn-outline-dark" target="_blank"><i class="fab fa-youtube"></i> YouTube</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="card shadow-lg border-0 mt-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-dark text-white text-center">
                    <h3 class="mb-0"><i class="fas fa-map-marker-alt"></i> Kontak & Lokasi</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <h5><i class="fas fa-map-pin text-danger"></i> Alamat</h5>
                            <p>{{ $konf->alamat_setting }}</p>
                            <h5><i class="fas fa-phone text-success"></i> Kontak</h5>
                            <p>No HP: {{ $konf->no_hp_setting }}</p>
                            <p>Email: {{ $konf->email_setting }}</p>
                        </div>
                        <div class="col-md-6 text-center animate__animated animate__fadeInRight">
                            <iframe src="{{ $konf->maps_setting }}" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animasi Wave di Bawah -->
    
</div>

<!-- Tambahkan CSS untuk animasi -->
<style>
    .wave-container {
        position: relative;
        bottom: -10px;
    }

    .wave {
        position: absolute;
        width: 100%;
        height: auto;
        bottom: 0;
    }
</style>
@endsection
