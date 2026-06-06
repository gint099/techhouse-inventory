@extends('layouts.app')

@section('page_title', 'Laporan Barang Keluar')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Laporan Barang Keluar</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="bi bi-receipt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Transaksi</span>
                            <span class="info-box-number">{{ $totalTransactions }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="bi bi-box-arrow-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Qty Keluar</span>
                            <span class="info-box-number">{{ $totalQuantity }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-danger card-outline shadow-sm">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0"><i class="bi bi-box-arrow-up me-2"></i>Laporan Barang Keluar</h3>
                    <div class="card-tools ms-auto">
                        @include('report.partials.export-buttons', ['routeName' => 'report.outs.export'])
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('report.outs') }}" class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari kode/tujuan...">
                        </div>
                        <div class="col-md-2">
                            <select name="item_id" class="form-select">
                                <option value="">Semua Barang</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" @selected($itemId == $item->id)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Barang</th>
                                    <th>Qty</th>
                                    <th>Tujuan</th>
                                    <th>Petugas</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($itemOuts as $itemOut)
                                    <tr>
                                        <td>{{ $itemOuts->firstItem() + $loop->index }}</td>
                                        <td>{{ $itemOut->kode_transaksi }}</td>
                                        <td>{{ $itemOut->tanggal_keluar->format('d M Y') }}</td>
                                        <td>{{ $itemOut->item->name }}</td>
                                        <td>{{ $itemOut->quantity }}</td>
                                        <td>{{ $itemOut->destination ?? '-' }}</td>
                                        <td>{{ $itemOut->user->name }}</td>
                                        <td>{{ $itemOut->description ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">Tidak ada data.</td></tr>
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
