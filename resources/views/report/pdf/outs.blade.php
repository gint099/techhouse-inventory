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
                <th>Tujuan</th>
                <th>Petugas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($itemOuts as $itemOut)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $itemOut->kode_transaksi }}</td>
                    <td>{{ $itemOut->tanggal_keluar->format('d/m/Y') }}</td>
                    <td>{{ $itemOut->item->name }}</td>
                    <td>{{ $itemOut->quantity }}</td>
                    <td>{{ $itemOut->destination ?? '-' }}</td>
                    <td>{{ $itemOut->user->name }}</td>
                    <td>{{ $itemOut->description ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
