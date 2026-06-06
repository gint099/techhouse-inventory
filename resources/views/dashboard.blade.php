@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner"><h3>{{ $totalItems }}</h3><p>Total Barang</p></div>
                        <div class="small-box-icon"><i class="bi bi-box-seam"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner"><h3>{{ $totalCategories }}</h3><p>Kategori</p></div>
                        <div class="small-box-icon"><i class="bi bi-tags"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner"><h3>{{ $totalUsers }}</h3><p>User</p></div>
                        <div class="small-box-icon"><i class="bi bi-people"></i></div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-4">
                    <div class="info-box text-bg-success">
                        <span class="info-box-icon"><i class="bi bi-box-arrow-in-down"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Barang Masuk</span>
                            <span class="info-box-number">{{ $totalItemIns }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box text-bg-danger">
                        <span class="info-box-icon"><i class="bi bi-box-arrow-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Barang Keluar</span>
                            <span class="info-box-number">{{ $totalItemOuts }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->isAdmin())
                <x-quick-action />
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <x-in-out-chart
                        :labels="$chartData['labels']"
                        :item-ins="$chartData['itemIns']"
                        :item-outs="$chartData['itemOuts']"
                    />
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-4">
                    <div class="card card-warning card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title text-warning fw-semibold"><i class="bi bi-exclamation-triangle me-2"></i>Stok Menipis</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <thead><tr><th>Barang</th><th>Stok</th></tr></thead>
                                <tbody>
                                    @forelse ($lowStockItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td><span class="badge bg-warning text-dark">{{ $item->stock }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">Tidak ada stok menipis.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-danger card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title text-danger fw-semibold"><i class="bi bi-x-circle me-2"></i>Stok Habis</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <thead><tr><th>Barang</th><th>Stok</th></tr></thead>
                                <tbody>
                                    @forelse ($emptyStockItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td><span class="badge bg-danger">0</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">Tidak ada stok habis.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title fw-semibold"><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm m-0">
                                <thead><tr><th>Kode</th><th>Tipe</th></tr></thead>
                                <tbody>
                                    @foreach ($recentItemIns as $in)
                                        <tr>
                                            <td>{{ $in->kode_transaksi }}</td>
                                            <td><span class="badge bg-success">Masuk</span></td>
                                        </tr>
                                    @endforeach
                                    @foreach ($recentItemOuts as $out)
                                        <tr>
                                            <td>{{ $out->kode_transaksi }}</td>
                                            <td><span class="badge bg-danger">Keluar</span></td>
                                        </tr>
                                    @endforeach
                                    @if ($recentItemIns->isEmpty() && $recentItemOuts->isEmpty())
                                        <tr><td colspan="2" class="text-center text-muted">Belum ada transaksi.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
