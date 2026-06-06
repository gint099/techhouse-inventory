@extends('layouts.app')

@section('page_title', 'Detail Barang')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-box-seam me-2"></i>{{ $item->name }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr><th width="200">Kode</th><td>{{ $item->kode }}</td></tr>
                                <tr><th>Kategori</th><td>{{ $item->category->name }}</td></tr>
                                <tr><th>Merek</th><td>{{ $item->merek ?? '-' }}</td></tr>
                                <tr><th>Stok</th><td>{{ $item->stock }} {{ $item->satuan }}</td></tr>
                                <tr><th>Stok Minimum</th><td>{{ $item->minimum_stock }}</td></tr>
                                <tr><th>Status</th>
                                    <td>
                                        @if ($item->stock === 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @elseif ($item->stock <= $item->minimum_stock)
                                            <span class="badge bg-warning text-dark">Menipis</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card card-success card-outline shadow-sm mt-3">
                        <div class="card-header"><h3 class="card-title">Riwayat Barang Masuk</h3></div>
                        <div class="card-body p-0">
                            <table class="table table-sm mb-0">
                                <thead><tr><th>Kode</th><th>Tanggal</th><th>Qty</th><th>User</th></tr></thead>
                                <tbody>
                                    @forelse ($item->itemIns->take(5) as $in)
                                        <tr>
                                            <td>{{ $in->kode_transaksi }}</td>
                                            <td>{{ $in->tanggal_masuk->format('d M Y') }}</td>
                                            <td>{{ $in->quantity }}</td>
                                            <td>{{ $in->user->name }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada transaksi masuk.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card card-danger card-outline shadow-sm mt-3">
                        <div class="card-header"><h3 class="card-title">Riwayat Barang Keluar</h3></div>
                        <div class="card-body p-0">
                            <table class="table table-sm mb-0">
                                <thead><tr><th>Kode</th><th>Tanggal</th><th>Qty</th><th>Tujuan</th></tr></thead>
                                <tbody>
                                    @forelse ($item->itemOuts->take(5) as $out)
                                        <tr>
                                            <td>{{ $out->kode_transaksi }}</td>
                                            <td>{{ $out->tanggal_keluar->format('d M Y') }}</td>
                                            <td>{{ $out->quantity }}</td>
                                            <td>{{ $out->destination ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada transaksi keluar.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
