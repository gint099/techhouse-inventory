@extends('report.pdf.layout')

@section('content')
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Min. Stok</th>
                <th>Satuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->minimum_stock }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>
                        @if ($item->stock === 0)
                            Habis
                        @elseif ($item->stock <= $item->minimum_stock)
                            Menipis
                        @else
                            Tersedia
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
