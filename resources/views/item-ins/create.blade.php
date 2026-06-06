@extends('layouts.app')

@section('page_title', 'Tambah Barang Masuk')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('item-ins.index') }}">Barang Masuk</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-box-arrow-in-down me-2"></i>Tambah Barang Masuk</h3>
                            <div class="card-tools">
                                <a href="{{ route('item-ins.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>

                        <form action="{{ route('item-ins.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">No Transaksi</label>
                                        <input type="text" class="form-control" value="{{ $kodeTransaksi }}" readonly>
                                        <small class="text-muted">Dibuat otomatis saat disimpan.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                        <input id="tanggal_masuk" name="tanggal_masuk" type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', now()->toDateString()) }}">
                                        @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="item_id" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                        <select id="item_id" name="item_id" class="form-select @error('item_id') is-invalid @enderror">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}" data-stock="{{ $item->stock }}" @selected(old('item_id') == $item->id)>{{ $item->kode }} - {{ $item->name }} (Stok: {{ $item->stock }})</option>
                                            @endforeach
                                        </select>
                                        @error('item_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="quantity" class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                                        <input id="quantity" name="quantity" type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}">
                                        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="{{ route('item-ins.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
