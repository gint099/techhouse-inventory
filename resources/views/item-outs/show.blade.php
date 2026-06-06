@extends('layouts.app')

@section('page_title', 'Detail Barang Keluar')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('item-outs.index') }}">Barang Keluar</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card card-danger card-outline shadow-sm mt-4">
                <div class="card-header">
                    <h3 class="card-title">{{ $itemOut->kode_transaksi }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('item-outs.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th width="200">Kode Transaksi</th><td>{{ $itemOut->kode_transaksi }}</td></tr>
                        <tr><th>Tanggal Keluar</th><td>{{ $itemOut->tanggal_keluar->format('d M Y') }}</td></tr>
                        <tr><th>Barang</th><td>{{ $itemOut->item->kode }} - {{ $itemOut->item->name }}</td></tr>
                        <tr><th>Kategori</th><td>{{ $itemOut->item->category->name }}</td></tr>
                        <tr><th>Jumlah</th><td>{{ $itemOut->quantity }} {{ $itemOut->item->satuan }}</td></tr>
                        <tr><th>Tujuan</th><td>{{ $itemOut->destination ?? '-' }}</td></tr>
                        <tr><th>Petugas</th><td>{{ $itemOut->user->name }}</td></tr>
                        <tr><th>Keterangan</th><td>{{ $itemOut->description ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
