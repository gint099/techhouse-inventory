<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'kode',
        'category_id',
        'name',
        'merek',
        'stock',
        'minimum_stock',
        'satuan',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function itemIns()
    {
        return $this->hasMany(ItemIn::class);
    }

    public function itemOuts()
    {
        return $this->hasMany(ItemOut::class);
    }
}
