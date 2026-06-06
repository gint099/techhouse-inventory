<x-guest-layout title="Masuk" subtitle="Masuk ke akun TechHouse Anda">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-3">
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Email" required autofocus autocomplete="username">
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
                placeholder="Password" required autocomplete="current-password">
            <div class="input-group-text">
                <span class="bi bi-lock-fill"></span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-7">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                </div>
            </div>
            <div class="col-5 text-end">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small">{{ __('Forgot your password?') }}</a>
                @endif
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-1"></i>
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="text-center mt-3 mb-0">
            <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar</a>
        </p>
    @endif
</x-guest-layout>
