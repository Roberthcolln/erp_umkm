@extends('layouts.index')
@section('content')

<?php
$title = '';
?>

<h2>Data Pelanggan</h2>

@if(isset($data) && isset($data['status']) && $data['status'])
<div class="table-container">
    <table class="table table-bordered" id="example2">
        <tr>
            <th>ID Pelanggan</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Lattitude</th>
            <th>Longitude</th>
            <th>Jenis</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Lembar Rekening</th>
            <th>Harga Air</th>
            <th>Denda</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>{{ $data['idpel'] }}</td>
            <td>{{ $data['nama'] }}</td>
            <td>{{ $data['alamat'] }}</td>
            <td>{{ $data['lat'] }}</td>
            <td>{{ $data['lon'] }}</td>
            <td>{{ $data['jenis'] }}</td>
            <td>{{ $data['nohp'] }}</td>
            <td>{{ $data['email'] }}</td>
            <td>{{ $data['lembar_rekening'] }}</td>
            <td>Rp. {{ number_format($data['harga_air'], 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($data['denda'], 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($data['total'], 0, ',', '.') }}</td>
        </tr>
    </table>

    <h3>Rincian Tagihan</h3>
    <table class="table table-bordered" id="example2">
        <tr>
            <th>Bulan</th>
            <th>Pakai</th>
            <th>Tagihan</th>
            <th>Denda</th>
        </tr>
        @if(isset($data['rincian']) && is_array($data['rincian']))
            @foreach($data['rincian'] as $rincian)
                <tr>
                    <td>{{ $rincian['bulan'] }}</td>
                    <td>{{ $rincian['pakai'] }}</td>
                    <td>Rp. {{ number_format($rincian['tagihan'], 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($rincian['denda'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
    </table>

    <h3>Rincian Non-Air</h3>
    <table class="table table-bordered" id="example2">
        <tr>
            <th>Periode</th>
            <th>Tagihan</th>
            <th>Uraian</th>
            <th>Tanggal</th>
            <th>Kasir</th>
        </tr>
        @if(isset($data['rwAir']['rincianNA']) && is_array($data['rwAir']['rincianNA']))
            @foreach($data['rwAir']['rincianNA'] as $rincianNA)
                <tr>
                    <td>{{ $rincianNA['periode'] }}</td>
                    <td>{{ $rincianNA['tagihan'] }}</td>
                    <td>{{ $rincianNA['uraian'] }}</td>
                    <td>
                        @if(isset($rincianNA['tanggal']))
                            {{ Carbon\Carbon::parse($rincianNA['tanggal'])->isoFormat('dddd, D MMMM Y HH:mm:ss') }}
                        @else
                            Tanggal not available
                        @endif
                    </td>
                    <td>
                        @if(isset($rincianNA['kasir']))
                            {{ $rincianNA['kasir'] }}
                        @else
                            Kasir not available
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
@else
<p>Tidak ada data yang ditemukan.</p>
@endif

<style>
    .table-container {
        margin-top: 20px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #dddddd;
        padding: 8px;
        text-align: left;
    }

    .data-table th {
        background-color: #f2f2f2;
    }
</style>

@endsection
