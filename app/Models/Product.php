<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     *
     * @return belongsToMany
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class)->withTimestamps()->withPivot('price');
    }
}
