<x-guest-layout title="Lupa Password" subtitle="Reset password akun Anda">
    <p class="text-muted small mb-3">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group mb-3">
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Email" required autofocus>
            <div class="input-group-text">
                <span class="bi bi-envelope"></span>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-1"></i>
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>

    <p class="text-center mt-3 mb-0">
        <a href="{{ route('login') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke login
        </a>
    </p>
</x-guest-layout>
