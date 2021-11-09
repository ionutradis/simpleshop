<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $cart = Cart::contents();
        $total = Cart::total();
        $errors = Cart::errors();
        return view('cart/show', compact(['cart', 'total', 'errors']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        //
        $quantity = 1;
        if(Cart::contents() && Cart::contents()->count() > 0) {
            $cartItem = Cart::contents()->where('product_id', $product->id)->first();
            $quantity = $cartItem ? $cartItem->quantity+1 : 1;
        }
        Cart::add($product, $quantity);
        Session::put('message', $product->name . ' has been added to cart');
        return redirect()->route('cart.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\addItem
     */
    public function edit(CartItems $item, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItems $item)
    {
        //
        Cart::add($item->product, $request->get('quantity'));
        Session::put('message', 'Item has been updated');
        return redirect()->route('cart.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItems $item)
    {
        //
        $item->delete();
        Session::put('message', 'Item was succesfully deleted');
        return redirect()->route('cart.show');
    }
}
