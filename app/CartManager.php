<?php
namespace  App;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartManager {

    const SESSION_KEY_LENGTH = 32;
    private $user;
    private $cart_instance;
    private $cart_items = false;
    private $session_key;
    private $errors = [];
    private $cartItemAttributes = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function __construct()
    {
        // create instance of cart
        $this->instantiateCart();
    }

    public function addItem(Product $product, $quantity = false, $cart_instance = false) {
        $newQty = false !== $quantity ? (int)$quantity : 1;
        $this->updateCartItem($cart_instance ? $cart_instance->id : $this->cart_instance->id, (object)[
            'cart_id'       =>  $cart_instance ? $cart_instance->id : $this->cart_instance->id,
            'product_id'    =>  $product->id,
            'quantity'      =>  $newQty,
            'price'         =>  $product->price
        ]);
    }
    private function updateCartItem($cart_id = false, $product) {
        $cartItem = new CartItems();
        if($cart_id) {
            if($searchCartItem = $cartItem->where('cart_id', $cart_id)->where('product_id', $product->product_id)->first()) {
                $cartItem = $searchCartItem;
            }
        }
        foreach($this->cartItemAttributes as $attribute) {
            if(property_exists($product, $attribute)) {
                $cartItem->{$attribute} = $product->{$attribute};
            }
        }
        if(property_exists($product, 'quantity') && $product->quantity < 1) {
            $cartItem->delete();
        } else {
            $cartItem->save();
        }
    }
    public function getItems() {
        return $this->cart_items;
    }
    private function setItems() {
        $this->cart_items = $this->cart_instance->cartItems ?? false;
    }
    private function instantiateCart() {
        // set the session key if exists
        if(Session::has('session_key') === null) {
            $this->cart_instance = $this->createCart();
        } else {
            if(Auth::check()) {
                $getUserCart = Cart::where('user_id', Auth::user()->id)->first();
                if($getUserCart && $getUserCart->session_key !== Session::get('session_key')) {
                    $initialSessionKey = Session::get('session_key');
                    Session::forget('session_key');
                    Session::put('session_key', $getUserCart->session_key);
                    $getInitialSessionCart = Cart::where('session_key', $initialSessionKey)->first();
                    if($getInitialSessionCart && isset($getInitialSessionCart->cartItems) && $getInitialSessionCart->cartItems->count() > 0) {
                        $getInitialSessionCart->cartItems->filter(function($item) use ($getUserCart) {
                            $userCartItems = $getUserCart->cartItems->where('product_id', $item->product_id)->first();
                            $this->addItem($item->product, ($item->quantity+($userCartItems ? $userCartItems->quantity : 1)), $getUserCart);
                            $item->delete();
                        });
                        $getInitialSessionCart->delete();
                    }
                    $this->cart_instance = Cart::where('user_id', Auth::user()->id)->first();
                } else {
                    $cartSession = Cart::where('session_key', Session::get('session_key'))->where('user_id', 0);
                    if(Session::has('session_key') === false) {
                        $this->createCart();
                    }
                    $cartSession->update(['user_id'=>Auth::user()->id]);
                    $this->cart_instance = Cart::where('session_key', Session::get('session_key'))->first();
                }
            } else {
                $this->cart_instance = Cart::where('session_key', Session::get('session_key'))->first() ? Cart::where('session_key', Session::get('session_key'))->first() : $this->createCart();
            }
        }
        // gather items of the instantiated cart
        $this->setItems();
    }

    private function createCart() {
        $this->session_key = Str::random(static::SESSION_KEY_LENGTH);
        Session::forget('session_key');
        Session::put('session_key', $this->session_key);

        return Cart::create([
            'session_key'=> $this->session_key
        ]);
    }

    public function getErrors() {
        if(!$this->cart_items) {
            return [];
        }
        $this->cart_items->each(function($item) {
            if(!$item->product) {
                $this->errors[] = 'A product from your cart does not exist anymore';
            }

            if($item->product && $item->quantity > $item->product->quantity) {
                $this->errors[] = sprintf('Product %s has exceeded the quantity limit', $item->product->name);
            }
        });
        return array_unique($this->errors);
    }

    public function forget() {
        Session::forget('session_key');
        $this->cart_instance->delete();
        $this->cart_items->each(function($item) {
            $item->delete();
        });
    }
}

?>
