<x-guest-layout title="Verifikasi Email" subtitle="Konfirmasi alamat email Anda">
    <p class="text-muted small mb-3">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-stretch">
        <form method="POST" action="{{ route('verification.send') }}" class="flex-grow-1">
            @csrf
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-envelope-arrow-up me-1"></i>
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="bi bi-box-arrow-right me-1"></i>
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
