<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'days',
        'total_price',
        'status',
        'rental_date',
        'return_date',
        'payment_proof'
    ];

    protected $dates = [
        'rental_date',
        'return_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
    'rental_date' => 'datetime',
    'return_date' => 'datetime',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
