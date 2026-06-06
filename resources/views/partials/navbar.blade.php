<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            @auth
                <li class="nav-item d-none d-md-block">
                    <span class="nav-link text-muted">
                        <i class="bi bi-person-badge me-1"></i>
                        {{ $navbarUser->roleLabel() }}
                    </span>
                </li>
            @endauth
        </ul>

        <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-label="Notifikasi stok">
                        <i class="bi bi-bell-fill"></i>
                        @if ($stockAlertCount > 0)
                            <span class="navbar-badge badge text-bg-warning">{{ $stockAlertCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <span class="dropdown-item dropdown-header">
                            {{ $stockAlertCount }} Peringatan Stok
                        </span>
                        <div class="dropdown-divider"></div>

                        @forelse ($stockAlerts as $item)
                            @php
                                $isEmpty = $item->stock === 0;
                                $alertUrl = $navbarUser->isAdmin()
                                    ? route('items.show', $item)
                                    : route('report.stocks', ['search' => $item->kode]);
                            @endphp
                            <a href="{{ $alertUrl }}" class="dropdown-item">
                                <i class="bi {{ $isEmpty ? 'bi-x-circle text-danger' : 'bi-exclamation-triangle text-warning' }} me-2"></i>
                                {{ $item->name }}
                                <span class="float-end text-secondary fs-7">
                                    Stok: {{ $item->stock }}
                                </span>
                            </a>
                            @if (! $loop->last)
                                <div class="dropdown-divider"></div>
                            @endif
                        @empty
                            <span class="dropdown-item text-muted">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Semua stok dalam kondisi aman.
                            </span>
                        @endforelse

                        @if ($stockAlertCount > 0)
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('report.stocks', ['status' => 'low']) }}" class="dropdown-item dropdown-footer">
                                Lihat Semua Peringatan Stok
                            </a>
                        @endif
                    </div>
                </li>
            @endauth

            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen" aria-label="Layar penuh">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="bd-theme" aria-label="Ubah tema"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
                    <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
                    <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme"
                    style="--bs-dropdown-min-width: 8rem">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center"
                            data-bs-theme-value="light" aria-pressed="false">
                            <i class="bi bi-sun-fill me-2"></i>
                            Light
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center"
                            data-bs-theme-value="dark" aria-pressed="false">
                            <i class="bi bi-moon-fill me-2"></i>
                            Dark
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active"
                            data-bs-theme-value="auto" aria-pressed="true">
                            <i class="bi bi-circle-half me-2"></i>
                            Auto
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                </ul>
            </li>

            @auth
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ $navbarUser->avatarUrl() }}" class="user-image rounded-circle shadow"
                            alt="{{ $navbarUser->name }}" />
                        <span class="d-none d-md-inline">{{ $navbarUser->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <li class="user-header text-bg-primary">
                            <img src="{{ $navbarUser->avatarUrl(150) }}" class="rounded-circle shadow"
                                alt="{{ $navbarUser->name }}" />
                            <p>
                                {{ $navbarUser->name }} — {{ $navbarUser->roleLabel() }}
                                <small>Bergabung {{ $navbarUser->created_at->format('M Y') }}</small>
                            </p>
                            <small class="d-block opacity-75">{{ $navbarUser->email }}</small>
                        </li>
                        <li class="user-footer d-flex justify-content-between gap-2 px-3 py-2 bg-body">
                            <a href="{{ route('profiles.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-person me-1"></i> Profil
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
    </div>
</nav>
