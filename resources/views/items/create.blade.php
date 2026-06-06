@extends('layouts.app')

@section('page_title', 'Tambah Barang')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card card-primary card-outline mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-plus-circle me-2"></i>Tambah Barang</h3>
                            <div class="card-tools">
                                <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('items.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kode" class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                                        <input id="kode" name="kode" type="text" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" placeholder="Contoh: BRG001">
                                        @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="merek" class="form-label fw-semibold">Merek</label>
                                    <input id="merek" name="merek" type="text" class="form-control @error('merek') is-invalid @enderror" value="{{ old('merek') }}">
                                    @error('merek')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="stock" class="form-label fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                                        <input id="stock" name="stock" type="number" min="0" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}">
                                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="minimum_stock" class="form-label fw-semibold">Stok Minimum <span class="text-danger">*</span></label>
                                        <input id="minimum_stock" name="minimum_stock" type="number" min="0" class="form-control @error('minimum_stock') is-invalid @enderror" value="{{ old('minimum_stock', 5) }}">
                                        @error('minimum_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="satuan" class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                                        <input id="satuan" name="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan', 'Pcs') }}">
                                        @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <a href="{{ route('items.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Barang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
