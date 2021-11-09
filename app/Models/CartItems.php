<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id'];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
