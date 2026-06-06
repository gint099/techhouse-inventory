<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemIn;
use App\Models\ItemOut;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalItemIns = ItemIn::count();
        $totalItemOuts = ItemOut::count();
        $lowStockItems = Item::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->limit(5)
            ->get();
        $emptyStockItems = Item::with('category')
            ->where('stock', 0)
            ->orderBy('name')
            ->limit(5)
            ->get();
        $recentItemIns = ItemIn::with(['item', 'user'])
            ->latest('tanggal_masuk')
            ->latest()
            ->limit(5)
            ->get();
        $recentItemOuts = ItemOut::with(['item', 'user'])
            ->latest('tanggal_keluar')
            ->latest()
            ->limit(5)
            ->get();

        $chartData = $this->getMonthlyChartData();

        return view('dashboard', compact(
            'totalItems',
            'totalCategories',
            'totalUsers',
            'totalItemIns',
            'totalItemOuts',
            'lowStockItems',
            'emptyStockItems',
            'recentItemIns',
            'recentItemOuts',
            'chartData',
        ));
    }

    private function getMonthlyChartData(): array
    {
        $months = collect(range(5, 0))->map(fn (int $i) => now()->subMonths($i)->startOfMonth());

        $labels = $months->map(fn ($date) => $date->translatedFormat('M Y'))->values()->all();

        $itemIns = $months->map(fn ($date) => (int) ItemIn::query()
            ->whereYear('tanggal_masuk', $date->year)
            ->whereMonth('tanggal_masuk', $date->month)
            ->sum('quantity'))->values()->all();

        $itemOuts = $months->map(fn ($date) => (int) ItemOut::query()
            ->whereYear('tanggal_keluar', $date->year)
            ->whereMonth('tanggal_keluar', $date->month)
            ->sum('quantity'))->values()->all();

        return [
            'labels' => $labels,
            'itemIns' => $itemIns,
            'itemOuts' => $itemOuts,
        ];
    }
}
