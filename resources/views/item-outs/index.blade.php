@extends('layouts.app')

@section('page_title', 'Barang Keluar')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Barang Keluar</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner"><h3>{{ $totalTransactions }}</h3><p>Total Transaksi</p></div>
                        <div class="icon"><i class="bi bi-receipt"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner"><h3>{{ $todayTransactions }}</h3><p>Hari Ini</p></div>
                        <div class="icon"><i class="bi bi-calendar-check"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner"><h3>{{ $monthQuantity }}</h3><p>Qty Bulan Ini</p></div>
                        <div class="icon"><i class="bi bi-calendar-month"></i></div>
                    </div>
                </div>
            </div>

            <div class="card card-danger card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-box-arrow-up me-2"></i>Transaksi Barang Keluar</h3>
                    <div class="card-tools">
                        <a href="{{ route('item-outs.create') }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-plus-lg me-2"></i>Tambah Transaksi
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('item-outs.index') }}" class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari kode transaksi...">
                        </div>
                        <div class="col-md-3">
                            <select name="item_id" class="form-select">
                                <option value="">Semua Barang</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" @selected($itemId == $item->id)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_keluar" value="{{ $date }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Cari</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Barang</th>
                                    <th>Qty</th>
                                    <th>Tujuan</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($itemOuts as $itemOut)
                                    <tr>
                                        <td>{{ $itemOuts->firstItem() + $loop->index }}</td>
                                        <td><span class="badge bg-dark">{{ $itemOut->kode_transaksi }}</span></td>
                                        <td>{{ $itemOut->tanggal_keluar->format('d M Y') }}</td>
                                        <td>{{ $itemOut->item->name }}</td>
                                        <td>{{ $itemOut->quantity }}</td>
                                        <td>{{ $itemOut->destination ?? '-' }}</td>
                                        <td>{{ $itemOut->user->name }}</td>
                                        <td>
                                            <a href="{{ route('item-outs.show', $itemOut) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                            <form action="{{ route('item-outs.destroy', $itemOut) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">{{ $itemOuts->links() }}</div>
            </div>
        </div>
    </div>
@endsection
