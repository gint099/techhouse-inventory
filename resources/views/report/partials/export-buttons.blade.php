@props(['routeName'])

@php
    $query = request()->query();
@endphp

<div class="btn-group">
    <a href="{{ route($routeName, ['format' => 'excel'] + $query) }}" class="btn btn-success btn-sm">
        <i class="bi bi-file-earmark-excel me-1"></i> Excel
    </a>
    <a href="{{ route($routeName, ['format' => 'pdf'] + $query) }}" class="btn btn-danger btn-sm">
        <i class="bi bi-file-earmark-pdf me-1"></i> PDF
    </a>
</div>
