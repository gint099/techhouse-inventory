<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOut extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'item_id',
        'user_id',
        'tanggal_keluar',
        'quantity',
        'destination',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_keluar' => 'date',
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
