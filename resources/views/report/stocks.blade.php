@extends('layouts.app')

@section('page_title', 'Laporan Stok')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Laporan Stok</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="small-box text-bg-primary">
                        <div class="inner"><h3>{{ $totalItems }}</h3><p>Total Barang</p></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box text-bg-warning">
                        <div class="inner"><h3>{{ $lowStockCount }}</h3><p>Stok Menipis</p></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box text-bg-danger">
                        <div class="inner"><h3>{{ $emptyStockCount }}</h3><p>Stok Habis</p></div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0"><i class="bi bi-boxes me-2"></i>Laporan Stok Barang</h3>
                    <div class="card-tools ms-auto">
                        @include('report.partials.export-buttons', ['routeName' => 'report.stocks.export'])
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('report.stocks') }}" class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari barang...">
                        </div>
                        <div class="col-md-3">
                            <select name="category_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($categoryId == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="available" @selected($status === 'available')>Tersedia</option>
                                <option value="low" @selected($status === 'low')>Menipis</option>
                                <option value="empty" @selected($status === 'empty')>Habis</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Min. Stok</th>
                                    <th>Satuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $items->firstItem() + $loop->index }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->minimum_stock }}</td>
                                        <td>{{ $item->satuan }}</td>
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
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">{{ $items->links() }}</div>
            </div>
        </div>
    </div>
@endsection
