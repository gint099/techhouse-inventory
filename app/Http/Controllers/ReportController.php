<?php

namespace App\Http\Controllers;

use App\Exports\ItemInReportExport;
use App\Exports\ItemOutReportExport;
use App\Exports\StockReportExport;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemIn;
use App\Models\ItemOut;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function stocks(Request $request)
    {
        $search = $request->string('search')->toString();
        $categoryId = $request->integer('category_id') ?: null;
        $status = $request->string('status')->toString();

        $items = $this->stockQuery($request)
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $totalItems = Item::count();
        $lowStockCount = Item::whereColumn('stock', '<=', 'minimum_stock')->where('stock', '>', 0)->count();
        $emptyStockCount = Item::where('stock', 0)->count();

        return view('report.stocks', compact(
            'items',
            'categories',
            'search',
            'categoryId',
            'status',
            'totalItems',
            'lowStockCount',
            'emptyStockCount'
        ));
    }

    public function exportStocks(Request $request, string $format)
    {
        $items = $this->stockQuery($request)->get();
        $filename = 'laporan-stok-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new StockReportExport($items), $filename.'.xlsx');
        }

        return $this->downloadPdf('report.pdf.stocks', [
            'title' => 'Laporan Stok Barang',
            'items' => $items,
            'filters' => $this->stockFilterLabels($request),
        ], $filename, $request);
    }

    public function ins(Request $request)
    {
        $search = $request->string('search')->toString();
        $itemId = $request->integer('item_id') ?: null;
        $startDate = $request->date('start_date')?->toDateString();
        $endDate = $request->date('end_date')?->toDateString();

        $itemIns = $this->itemInQuery($request)
            ->paginate(15)
            ->withQueryString();

        $items = Item::orderBy('name')->get();
        $totalTransactions = ItemIn::count();
        $totalQuantity = ItemIn::sum('quantity');

        return view('report.ins', compact(
            'itemIns',
            'items',
            'search',
            'itemId',
            'startDate',
            'endDate',
            'totalTransactions',
            'totalQuantity'
        ));
    }

    public function exportIns(Request $request, string $format)
    {
        $itemIns = $this->itemInQuery($request)->get();
        $filename = 'laporan-barang-masuk-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new ItemInReportExport($itemIns), $filename.'.xlsx');
        }

        return $this->downloadPdf('report.pdf.ins', [
            'title' => 'Laporan Barang Masuk',
            'itemIns' => $itemIns,
            'filters' => $this->itemInFilterLabels($request),
        ], $filename, $request);
    }

    public function outs(Request $request)
    {
        $search = $request->string('search')->toString();
        $itemId = $request->integer('item_id') ?: null;
        $startDate = $request->date('start_date')?->toDateString();
        $endDate = $request->date('end_date')?->toDateString();

        $itemOuts = $this->itemOutQuery($request)
            ->paginate(15)
            ->withQueryString();

        $items = Item::orderBy('name')->get();
        $totalTransactions = ItemOut::count();
        $totalQuantity = ItemOut::sum('quantity');

        return view('report.outs', compact(
            'itemOuts',
            'items',
            'search',
            'itemId',
            'startDate',
            'endDate',
            'totalTransactions',
            'totalQuantity'
        ));
    }

    public function exportOuts(Request $request, string $format)
    {
        $itemOuts = $this->itemOutQuery($request)->get();
        $filename = 'laporan-barang-keluar-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new ItemOutReportExport($itemOuts), $filename.'.xlsx');
        }

        return $this->downloadPdf('report.pdf.outs', [
            'title' => 'Laporan Barang Keluar',
            'itemOuts' => $itemOuts,
            'filters' => $this->itemOutFilterLabels($request),
        ], $filename, $request);
    }

    private function stockQuery(Request $request): Builder
    {
        $search = $request->string('search')->toString();
        $categoryId = $request->integer('category_id') ?: null;
        $status = $request->string('status')->toString();

        return Item::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('merek', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($status === 'low', fn ($query) => $query->whereColumn('stock', '<=', 'minimum_stock')->where('stock', '>', 0))
            ->when($status === 'empty', fn ($query) => $query->where('stock', 0))
            ->when($status === 'available', fn ($query) => $query->whereColumn('stock', '>', 'minimum_stock'))
            ->orderBy('name');
    }

    private function itemInQuery(Request $request): Builder
    {
        $search = $request->string('search')->toString();
        $itemId = $request->integer('item_id') ?: null;
        $startDate = $request->date('start_date')?->toDateString();
        $endDate = $request->date('end_date')?->toDateString();

        return ItemIn::with(['item.category', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode_transaksi', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($itemId, fn ($query) => $query->where('item_id', $itemId))
            ->when($startDate, fn ($query) => $query->whereDate('tanggal_masuk', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->whereDate('tanggal_masuk', '<=', $endDate))
            ->latest('tanggal_masuk')
            ->latest();
    }

    private function itemOutQuery(Request $request): Builder
    {
        $search = $request->string('search')->toString();
        $itemId = $request->integer('item_id') ?: null;
        $startDate = $request->date('start_date')?->toDateString();
        $endDate = $request->date('end_date')?->toDateString();

        return ItemOut::with(['item.category', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode_transaksi', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('destination', 'like', "%{$search}%");
                });
            })
            ->when($itemId, fn ($query) => $query->where('item_id', $itemId))
            ->when($startDate, fn ($query) => $query->whereDate('tanggal_keluar', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->whereDate('tanggal_keluar', '<=', $endDate))
            ->latest('tanggal_keluar')
            ->latest();
    }

    private function stockFilterLabels(Request $request): array
    {
        $filters = [];

        if ($search = $request->string('search')->toString()) {
            $filters[] = "Pencarian: {$search}";
        }

        if ($categoryId = $request->integer('category_id')) {
            $category = Category::find($categoryId);
            $filters[] = 'Kategori: '.($category?->name ?? $categoryId);
        }

        if ($status = $request->string('status')->toString()) {
            $statusLabel = match ($status) {
                'available' => 'Tersedia',
                'low' => 'Menipis',
                'empty' => 'Habis',
                default => $status,
            };
            $filters[] = "Status: {$statusLabel}";
        }

        return $filters;
    }

    private function itemInFilterLabels(Request $request): array
    {
        return $this->transactionFilterLabels($request);
    }

    private function itemOutFilterLabels(Request $request): array
    {
        return $this->transactionFilterLabels($request);
    }

    private function transactionFilterLabels(Request $request): array
    {
        $filters = [];

        if ($search = $request->string('search')->toString()) {
            $filters[] = "Pencarian: {$search}";
        }

        if ($itemId = $request->integer('item_id')) {
            $item = Item::find($itemId);
            $filters[] = 'Barang: '.($item?->name ?? $itemId);
        }

        if ($startDate = $request->date('start_date')?->toDateString()) {
            $filters[] = "Dari: {$startDate}";
        }

        if ($endDate = $request->date('end_date')?->toDateString()) {
            $filters[] = "Sampai: {$endDate}";
        }

        return $filters;
    }

    private function downloadPdf(string $view, array $data, string $filename, Request $request): Response
    {
        $pdf = Pdf::loadView($view, array_merge($data, [
            'generatedAt' => now(),
            'user' => $request->user(),
        ]))->setPaper('a4', 'landscape');

        return $pdf->download($filename.'.pdf');
    }
}
