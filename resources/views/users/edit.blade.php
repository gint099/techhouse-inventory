@extends('layouts.app')

@section('page_title', 'Edit User')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card card-warning card-outline mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-pencil-square me-2"></i>Edit User</h3>
                            <div class="card-tools">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                            </div>
                        </div>

                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror">
                                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                                        <option value="manager" @selected(old('role', $user->role) === 'manager')>Manager</option>
                                    </select>
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning text-dark fw-semibold"><i class="bi bi-check-circle me-2"></i>Update User</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
