@extends('layouts.app')

@section('page_title', 'Ganti Password')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('profiles.index') }}">Profil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('status') === 'password-updated')
                <div class="alert alert-success">Password berhasil diperbarui.</div>
            @endif

            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <div class="card card-warning card-outline mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-shield-lock me-2"></i>Ganti Password</h3>
                            <div class="card-tools">
                                <a href="{{ route('profiles.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Lama <span class="text-danger">*</span></label>
                                    <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                                    @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                    <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                                    <small class="text-muted">Minimal 8 karakter.</small>
                                    @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning text-dark fw-semibold">
                                    <i class="bi bi-check-circle me-2"></i>Update Password
                                </button>
                                <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
