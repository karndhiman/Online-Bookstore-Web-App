<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'price',
        'quantity',
        'genre',
        'condition',
        'cover_image',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available' && $this->quantity > 0;
    }

    public function markAsSold()
    {
        $this->update(['status' => 'sold']);
    }

    public function decreaseQuantity($quantity)
    {
        $this->decrement('quantity', $quantity);
        
        if ($this->quantity === 0) {
            $this->markAsSold();
        }
    }
}