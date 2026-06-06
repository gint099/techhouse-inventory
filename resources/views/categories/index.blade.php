@extends('layouts.app')

@section('page_title', 'Kategori')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Kategori</li>
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

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary">
                            <i class="bi bi-tags"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Kategori</span>
                            <span class="info-box-number">{{ $categories->total() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Data Kategori Barang</h3>
                    <div class="card-tools">
                        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg"></i> Kategori
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <form method="GET" action="{{ route('categories.index') }}" class="px-3 pt-3 pb-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search...">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped m-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Barang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="align-middle">
                                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge text-bg-primary">{{ $category->items_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
