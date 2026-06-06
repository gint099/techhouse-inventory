@extends('layouts.app')

@section('page_title', 'Tambah Barang Keluar')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('item-outs.index') }}">Barang Keluar</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-box-arrow-up me-2"></i>Tambah Barang Keluar</h3>
                            <div class="card-tools">
                                <a href="{{ route('item-outs.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>

                        <form action="{{ route('item-outs.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">No Transaksi</label>
                                        <input type="text" class="form-control" value="{{ $kodeTransaksi }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                        <input id="tanggal_keluar" name="tanggal_keluar" type="date" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ old('tanggal_keluar', now()->toDateString()) }}">
                                        @error('tanggal_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="item_id" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                        <select id="item_id" name="item_id" class="form-select @error('item_id') is-invalid @enderror">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}" @selected(old('item_id') == $item->id)>{{ $item->kode }} - {{ $item->name }} (Stok: {{ $item->stock }})</option>
                                            @endforeach
                                        </select>
                                        @error('item_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="quantity" class="form-label">Jumlah Keluar <span class="text-danger">*</span></label>
                                        <input id="quantity" name="quantity" type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}">
                                        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="destination" class="form-label">Tujuan <span class="text-danger">*</span></label>
                                        <input id="destination" name="destination" type="text" class="form-control @error('destination') is-invalid @enderror" value="{{ old('destination') }}" placeholder="Contoh: Divisi IT, Ruang Meeting">
                                        @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="{{ route('item-outs.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-danger"><i class="bi bi-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
