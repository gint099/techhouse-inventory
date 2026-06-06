@extends('layouts.app')

@section('page_title', 'Data Barang')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Data Barang</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $totalItems }}</h3>
                            <p>Total Barang</p>
                        </div>
                        <div class="icon"><i class="bi bi-box-seam"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $lowStockCount }}</h3>
                            <p>Stok Menipis</p>
                        </div>
                        <div class="icon"><i class="bi bi-exclamation-triangle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $emptyStockCount }}</h3>
                            <p>Stok Habis</p>
                        </div>
                        <div class="icon"><i class="bi bi-x-circle"></i></div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline mt-4 shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-box-seam me-2"></i>Data Barang</h3>
                    <div class="card-tools">
                        <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-2"></i>Tambah Barang
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('items.index') }}" class="row mb-3">
                        <div class="col-md-4">
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
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="bi bi-search me-2"></i>Cari
                            </button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Merek</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Status</th>
                                    <th width="180">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $items->firstItem() + $loop->index }}</td>
                                        <td><span class="badge bg-dark">{{ $item->kode }}</span></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->merek ?? '-' }}</td>
                                        <td>{{ $item->stock }}</td>
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
                                        <td>
                                            <a href="{{ route('items.show', $item) }}" class="btn btn-info btn-sm" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Belum ada data barang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
