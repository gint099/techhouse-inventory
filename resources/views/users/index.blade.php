@extends('layouts.app')

@section('page_title', 'Manajemen User')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
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
                        <div class="inner"><h3>{{ $totalUsers }}</h3><p>Total User</p></div>
                        <div class="icon"><i class="bi bi-people-fill"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-success">
                        <div class="inner"><h3>{{ $adminCount }}</h3><p>Admin</p></div>
                        <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box text-bg-info">
                        <div class="inner"><h3>{{ $managerCount }}</h3><p>Manager</p></div>
                        <div class="icon"><i class="bi bi-person-workspace"></i></div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline mt-4 shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-people me-2"></i>Manajemen User</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-2"></i>Tambah User
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('users.index') }}" class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari nama atau email...">
                        </div>
                        <div class="col-md-3">
                            <select name="role" class="form-select">
                                <option value="">Semua Role</option>
                                <option value="admin" @selected($role === 'admin')>Admin</option>
                                <option value="manager" @selected($role === 'manager')>Manager</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Cari</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $loop->index }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge {{ $user->role === 'admin' ? 'bg-success' : 'bg-info' }}">
                                                {{ $user->role === 'admin' ? 'Admin' : 'Manager' }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada user.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
@endsection
