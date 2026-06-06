<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class StockReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(private Collection $items) {}

    public function collection(): Collection
    {
        return $this->items;
    }

    public function headings(): array
    {
        return ['No', 'Kode', 'Nama', 'Kategori', 'Merek', 'Stok', 'Min. Stok', 'Satuan', 'Status'];
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $item->kode,
            $item->name,
            $item->category->name,
            $item->merek ?? '-',
            $item->stock,
            $item->minimum_stock,
            $item->satuan,
            $this->stockStatus($item),
        ];
    }

    public function title(): string
    {
        return 'Laporan Stok';
    }

    private function stockStatus($item): string
    {
        if ($item->stock === 0) {
            return 'Habis';
        }

        if ($item->stock <= $item->minimum_stock) {
            return 'Menipis';
        }

        return 'Tersedia';
    }
}
