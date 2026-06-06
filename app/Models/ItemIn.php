<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemIn extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'item_id',
        'user_id',
        'tanggal_masuk',
        'quantity',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
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
