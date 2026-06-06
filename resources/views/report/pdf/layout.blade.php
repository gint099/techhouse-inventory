<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }} | TechHouse</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { font-size: 10px; color: #666; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        tr:nth-child(even) { background: #fafafa; }
        .footer { margin-top: 16px; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">
        TechHouse — Sistem Inventaris Barang<br>
        Dicetak: {{ $generatedAt->format('d F Y H:i') }} | Oleh: {{ $user->name }}
        @if (!empty($filters))
            <br>Filter: {{ implode(' | ', $filters) }}
        @endif
    </div>

    @yield('content')

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem TechHouse.
    </div>
</body>
</html>
