@extends('layouts.app')

@section('page_title', 'Tambah Kategori')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card card-primary card-outline mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-tags me-2"></i>
                                Tambah Kategori Barang
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        Nama Kategori <span class="text-danger">*</span>
                                    </label>
                                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama kategori">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Masukkan deskripsi kategori...">{{ old('description') }}</textarea>
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
                                    Simpan Kategori
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-info card-outline mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informasi
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">
                                Kategori digunakan untuk mengelompokkan barang agar mudah dikelola dan dicari.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
