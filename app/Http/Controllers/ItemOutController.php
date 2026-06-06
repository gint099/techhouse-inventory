    <?php

    namespace App\Http\Controllers;

    use App\Models\Item;
    use App\Models\ItemOut;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use Illuminate\Validation\ValidationException;

    class ItemOutController extends Controller
    {
        public function index(Request $request)
        {
            $search = $request->string('search')->toString();
            $itemId = $request->integer('item_id') ?: null;
            $date = $request->date('tanggal_keluar')?->toDateString();

            $itemOuts = ItemOut::with(['item', 'user'])
                ->when($search, function ($query) use ($search) {
                    $query->where('kode_transaksi', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
                ->when($itemId, fn ($query) => $query->where('item_id', $itemId))
                ->when($date, fn ($query) => $query->whereDate('tanggal_keluar', $date))
                ->latest('tanggal_keluar')
                ->latest()
                ->paginate(10)
                ->withQueryString();

            $items = Item::orderBy('name')->get();
            $totalTransactions = ItemOut::count();
            $todayTransactions = ItemOut::whereDate('tanggal_keluar', today())->count();
            $monthQuantity = ItemOut::whereMonth('tanggal_keluar', now()->month)
                ->whereYear('tanggal_keluar', now()->year)
                ->sum('quantity');

            return view('item-outs.index', compact(
                'itemOuts',
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

            return view('item-outs.create', compact('items', 'kodeTransaksi'));
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'item_id' => ['required', 'exists:items,id'],
                'tanggal_keluar' => ['required', 'date'],
                'quantity' => ['required', 'integer', 'min:1'],
                'destination' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
            ]);

            $itemOut = DB::transaction(function () use ($validated, $request) {
                $item = Item::lockForUpdate()->findOrFail($validated['item_id']);

                if ($validated['quantity'] > $item->stock) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Jumlah keluar tidak boleh lebih besar dari stok tersedia.',
                    ]);
                }

                $itemOut = ItemOut::create([
                    'kode_transaksi' => $this->generateTransactionCode(),
                    'item_id' => $item->id,
                    'user_id' => $request->user()->id,
                    'tanggal_keluar' => $validated['tanggal_keluar'],
                    'quantity' => $validated['quantity'],
                    'destination' => $validated['destination'],
                    'description' => $validated['description'] ?? null,
                ]);

                $item->decrement('stock', $validated['quantity']);

                return $itemOut;
            });

            return redirect()
                ->route('item-outs.show', $itemOut)
                ->with('success', 'Barang keluar berhasil disimpan.');
        }

        public function show(ItemOut $itemOut)
        {
            $itemOut->load(['item.category', 'user']);

            return view('item-outs.show', compact('itemOut'));
        }

        public function destroy(ItemOut $itemOut)
        {
            DB::transaction(function () use ($itemOut) {
                $item = Item::lockForUpdate()->findOrFail($itemOut->item_id);

                $item->increment('stock', $itemOut->quantity);
                $itemOut->delete();
            });

            return redirect()
                ->route('item-outs.index')
                ->with('success', 'Transaksi barang keluar berhasil dihapus.');
        }

        private function generateTransactionCode(): string
        {
            $prefix = 'BK-' . now()->format('Ymd') . '-';
            $lastNumber = ItemOut::where('kode_transaksi', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderByDesc('kode_transaksi')
                ->value('kode_transaksi');

            $nextNumber = $lastNumber ? ((int) substr($lastNumber, -3)) + 1 : 1;

            return $prefix . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
        }
    }
