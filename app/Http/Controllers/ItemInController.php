<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ItemInController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $itemId = $request->integer('item_id') ?: null;
        $date = $request->date('tanggal_masuk')?->toDateString();

        $itemIns = ItemIn::with(['item', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($itemId, fn ($query) => $query->where('item_id', $itemId))
            ->when($date, fn ($query) => $query->whereDate('tanggal_masuk', $date))
            ->latest('tanggal_masuk')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $items = Item::orderBy('name')->get();
        $totalTransactions = ItemIn::count();
        $todayTransactions = ItemIn::whereDate('tanggal_masuk', today())->count();
        $monthQuantity = ItemIn::whereMonth('tanggal_masuk', now()->month)
            ->whereYear('tanggal_masuk', now()->year)
            ->sum('quantity');

        return view('item-ins.index', compact(
            'itemIns',
            'items',
            'search',
            'itemId',
            'date',
            'totalTransactions',
            'todayTransactions',
            'monthQuantity'
        ));
    }

    public function create()
    {
        $items = Item::orderBy('name')->get();
        $kodeTransaksi = $this->generateTransactionCode();

        return view('item-ins.create', compact('items', 'kodeTransaksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'tanggal_masuk' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $itemIn = DB::transaction(function () use ($validated, $request) {
            $item = Item::lockForUpdate()->findOrFail($validated['item_id']);

            $itemIn = ItemIn::create([
                'kode_transaksi' => $this->generateTransactionCode(),
                'item_id' => $item->id,
                'user_id' => $request->user()->id,
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'quantity' => $validated['quantity'],
                'description' => $validated['description'] ?? null,
            ]);

            $item->increment('stock', $validated['quantity']);

            return $itemIn;
        });

        return redirect()
            ->route('item-ins.show', $itemIn)
            ->with('success', 'Barang masuk berhasil disimpan.');
    }

    public function show(ItemIn $itemIn)
    {
        $itemIn->load(['item.category', 'user']);

        return view('item-ins.show', compact('itemIn'));
    }

    public function destroy(ItemIn $itemIn)
    {
        DB::transaction(function () use ($itemIn) {
            $item = Item::lockForUpdate()->findOrFail($itemIn->item_id);

            if ($item->stock < $itemIn->quantity) {
                abort(422, 'Stok barang tidak cukup untuk menghapus transaksi ini.');
            }

            $item->decrement('stock', $itemIn->quantity);
            $itemIn->delete();
        });

        return redirect()
            ->route('item-ins.index')
            ->with('success', 'Transaksi barang masuk berhasil dihapus.');
    }

    private function generateTransactionCode(): string
    {
        $prefix = 'BM-' . now()->format('Ymd') . '-';
        $lastNumber = ItemIn::where('kode_transaksi', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('kode_transaksi')
            ->value('kode_transaksi');

        $nextNumber = $lastNumber ? ((int) substr($lastNumber, -3)) + 1 : 1;

        return $prefix . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
