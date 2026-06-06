<?php

namespace App\View\Composers;

use App\Models\Item;
use Illuminate\View\View;

class NavbarComposer
{
    public function compose(View $view): void
    {
        $user = auth()->user();

        if (! $user) {
            $view->with([
                'navbarUser' => null,
                'stockAlertCount' => 0,
                'stockAlerts' => collect(),
            ]);

            return;
        }

        $stockAlertCount = Item::query()
            ->where(function ($query) {
                $query->where('stock', 0)
                    ->orWhere(function ($query) {
                        $query->whereColumn('stock', '<=', 'minimum_stock')
                            ->where('stock', '>', 0);
                    });
            })
            ->count();

        $stockAlerts = Item::query()
            ->where(function ($query) {
                $query->where('stock', 0)
                    ->orWhere(function ($query) {
                        $query->whereColumn('stock', '<=', 'minimum_stock')
                            ->where('stock', '>', 0);
                    });
            })
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get(['id', 'kode', 'name', 'stock', 'minimum_stock']);

        $view->with([
            'navbarUser' => $user,
            'stockAlertCount' => $stockAlertCount,
            'stockAlerts' => $stockAlerts,
        ]);
    }
}
