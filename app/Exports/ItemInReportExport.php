<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ItemInReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(private Collection $itemIns) {}

    public function collection(): Collection
    {
        return $this->itemIns;
    }

    public function headings(): array
    {
        return ['No', 'Kode Transaksi', 'Tanggal', 'Barang', 'Kategori', 'Qty', 'Petugas', 'Keterangan'];
    }

    public function map($itemIn): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $itemIn->kode_transaksi,
            $itemIn->tanggal_masuk->format('d/m/Y'),
            $itemIn->item->name,
            $itemIn->item->category->name,
            $itemIn->quantity,
            $itemIn->user->name,
            $itemIn->description ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Barang Masuk';
    }
}
