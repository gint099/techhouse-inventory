<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $categoryId = $request->integer('category_id') ?: null;

        $items = Item::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('merek', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $totalItems = Item::count();
        $lowStockCount = Item::whereColumn('stock', '<=', 'minimum_stock')->where('stock', '>', 0)->count();
        $emptyStockCount = Item::where('stock', 0)->count();

        return view('items.index', compact(
            'items',
            'categories',
            'search',
            'categoryId',
            'totalItems',
            'lowStockCount',
            'emptyStockCount'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', 'unique:items,kode'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'merek' => ['nullable', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:255'],
        ]);

        $item = Item::create($validated);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Item $item)
    {
        $item->load(['category', 'itemIns.user', 'itemOuts.user']);

        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();

        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', Rule::unique('items', 'kode')->ignore($item)],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'merek' => ['nullable', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:255'],
        ]);

        $item->update($validated);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if ($item->itemIns()->exists() || $item->itemOuts()->exists()) {
            return redirect()
                ->route('items.index')
                ->with('error', 'Barang tidak bisa dihapus karena sudah memiliki transaksi.');
        }

        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
