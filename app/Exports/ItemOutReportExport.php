<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ItemOutReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(private Collection $itemOuts) {}

    public function collection(): Collection
    {
        return $this->itemOuts;
    }

    public function headings(): array
    {
        return ['No', 'Kode Transaksi', 'Tanggal', 'Barang', 'Kategori', 'Qty', 'Tujuan', 'Petugas', 'Keterangan'];
    }

    public function map($itemOut): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $itemOut->kode_transaksi,
            $itemOut->tanggal_keluar->format('d/m/Y'),
            $itemOut->item->name,
            $itemOut->item->category->name,
            $itemOut->quantity,
            $itemOut->destination ?? '-',
            $itemOut->user->name,
            $itemOut->description ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Barang Keluar';
    }
}
