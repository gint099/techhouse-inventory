@extends('layouts.app')

@section('page_title', 'Profil Pengguna')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Profil</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row mt-4">
                <div class="col-lg-4">
                    <div class="card card-primary card-outline mb-4 shadow-sm">
                        <div class="card-body box-profile text-center">
                            <img class="profile-user-img img-fluid img-circle mb-3"
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0d6efd&color=fff&size=128"
                                alt="User profile picture">
                            <h3 class="profile-username">{{ $user->name }}</h3>
                            <p class="text-muted">{{ $user->role === 'admin' ? 'Administrator' : 'Manager' }}</p>
                            <span class="badge text-bg-primary mb-3">Active</span>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Role</b>
                                    <span class="float-end">{{ ucfirst($user->role) }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Barang Masuk</b>
                                    <span class="float-end">{{ $user->item_ins_count }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Barang Keluar</b>
                                    <span class="float-end">{{ $user->item_outs_count }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-person-circle me-2"></i>Informasi Profil</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <div class="form-control bg-light">{{ $user->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email</label>
                                    <div class="form-control bg-light">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Role</label>
                                    <div class="form-control bg-light">{{ ucfirst($user->role) }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Bergabung Sejak</label>
                                    <div class="form-control bg-light">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('profiles.edit') }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profil
                            </a>
                            <a href="{{ route('profiles.password') }}" class="btn btn-warning">
                                <i class="bi bi-key me-2"></i>Ganti Password
                            </a>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-clock-history me-2"></i>Aktivitas Terakhir</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentActivities as $activity)
                                        <tr>
                                            <td>{{ $activity['time']->format('d M Y H:i') }}</td>
                                            <td>{{ $activity['label'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-3">Belum ada aktivitas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
