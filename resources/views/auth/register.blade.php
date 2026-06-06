<x-guest-layout title="Daftar" subtitle="Buat akun baru TechHouse">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group mb-3">
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama lengkap" required autofocus autocomplete="name">
            <div class="input-group-text">
                <span class="bi bi-person"></span>
            </div>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Email" required autocomplete="username">
            <div class="input-group-text">
                <span class="bi bi-envelope"></span>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input id="password" type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Password" required autocomplete="new-password">
            <div class="input-group-text">
                <span class="bi bi-lock-fill"></span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Konfirmasi password" required autocomplete="new-password">
            <div class="input-group-text">
                <span class="bi bi-shield-lock"></span>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>
                {{ __('Register') }}
            </button>
        </div>
    </form>

    <p class="text-center mt-3 mb-0">
        <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Already registered?') }}</a>
    </p>
</x-guest-layout>
