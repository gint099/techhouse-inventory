<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilesController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $user->loadCount(['itemIns', 'itemOuts']);

        $recentActivities = collect()
            ->merge(
                $user->itemIns()
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn ($item) => [
                        'time' => $item->created_at,
                        'label' => 'Barang masuk: '.$item->kode_transaksi,
                    ])
            )
            ->merge(
                $user->itemOuts()
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(fn ($item) => [
                        'time' => $item->created_at,
                        'label' => 'Barang keluar: '.$item->kode_transaksi,
                    ])
            )
            ->sortByDesc('time')
            ->take(5)
            ->values();

        return view('profiles.index', compact('user', 'recentActivities'));
    }

    public function edit(Request $request): View
    {
        return view('profiles.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function password(): View
    {
        return view('profiles.password');
    }
}
