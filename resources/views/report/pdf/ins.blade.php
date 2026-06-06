@extends('report.pdf.layout')

@section('content')
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Petugas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($itemIns as $itemIn)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $itemIn->kode_transaksi }}</td>
                    <td>{{ $itemIn->tanggal_masuk->format('d/m/Y') }}</td>
                    <td>{{ $itemIn->item->name }}</td>
                    <td>{{ $itemIn->quantity }}</td>
                    <td>{{ $itemIn->user->name }}</td>
                    <td>{{ $itemIn->description ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
