<x-guest-layout title="Konfirmasi Password" subtitle="Area aman — verifikasi identitas Anda">
    <p class="text-muted small mb-3">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-shield-check me-1"></i>
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
