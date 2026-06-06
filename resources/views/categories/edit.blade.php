@extends('layouts.app')

@section('page_title', 'Edit Kategori')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card card-primary card-outline mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-pencil-square me-2"></i>
                                Edit Kategori Barang
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        Nama Kategori <span class="text-danger">*</span>
                                    </label>
                                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i>
                                    Update Kategori
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-info card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Kategori</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Barang</th>
                                    <td>
                                        <span class="badge bg-primary">{{ $category->items_count }} Barang</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Terakhir Update</th>
                                    <td>{{ $category->updated_at->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
