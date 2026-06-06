@extends('layouts.app')

@section('page_title', 'Detail Barang Masuk')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('item-ins.index') }}">Barang Masuk</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card card-success card-outline shadow-sm mt-4">
                <div class="card-header">
                    <h3 class="card-title">{{ $itemIn->kode_transaksi }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('item-ins.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th width="200">Kode Transaksi</th><td>{{ $itemIn->kode_transaksi }}</td></tr>
                        <tr><th>Tanggal Masuk</th><td>{{ $itemIn->tanggal_masuk->format('d M Y') }}</td></tr>
                        <tr><th>Barang</th><td>{{ $itemIn->item->kode }} - {{ $itemIn->item->name }}</td></tr>
                        <tr><th>Kategori</th><td>{{ $itemIn->item->category->name }}</td></tr>
                        <tr><th>Jumlah</th><td>{{ $itemIn->quantity }} {{ $itemIn->item->satuan }}</td></tr>
                        <tr><th>Petugas</th><td>{{ $itemIn->user->name }}</td></tr>
                        <tr><th>Keterangan</th><td>{{ $itemIn->description ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
