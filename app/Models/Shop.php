<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     *
     * @return belongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('price');
    }
}
