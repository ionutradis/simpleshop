<?php

namespace App\Models;

use App\CartManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_key'];

    public static function add(Product $product, $quantity = 1) {
        $cartInstance = new CartManager();
        $cartInstance->addItem($product, $quantity);
    }

    public static function contents() {
        $cartInstance = new CartManager();
        return $cartInstance->getItems();
    }

    public function cartItems() {
        return $this->hasMany(CartItems::class);
    }

    public static function total() {
        $total = 0;
        if(static::contents()) {
            foreach(static::contents() as $item) {
                $total += $item->quantity*$item->price;
            }
        }
        return $total;
    }

    public static function errors() {
        $cartInstance = new CartManager();
        return $cartInstance->getErrors();
    }

    public static function forget() {
        $cartInstance = new CartManager();
        return $cartInstance->forget();
    }

}
