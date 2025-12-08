<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_per_day',
        'stok',
        'image',
        'description',
        'category_id', // pastikan ini ada
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Rental
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
