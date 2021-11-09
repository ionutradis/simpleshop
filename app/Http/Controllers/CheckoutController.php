<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTotals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index() {
        $cart = Cart::contents();
        $total = Cart::total();
        $errors = Cart::errors();
        $coupons = Auth::user()->coupons;
        if(count($errors)) {
            return redirect()->route('cart.show');
        }
        if(Cart::contents()->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Cannot checkout with no products in your cart');
        }

        return view('checkout.index', compact(['cart', 'total', 'coupons']));
    }

    public function confirm(Request $request) {
        $cartProducts = Cart::contents();
        $total = Cart::total();
        $errors = Cart::errors();
        if(count($errors)) {
            return redirect()->route('cart.show');
        }
        if(Cart::contents()->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Cannot checkout with no products in your cart');
        }

        // Form validation
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'street' => 'required',
            'postcode' => 'required',
            'street_number' => 'required',
            'country_code' => 'required',
            'telephone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'voucher'   => ''
        ]);
        $request->request->add(['user_id'=>Auth::user()->id]);
        $request->request->add(['total'=>$total]);

        //  Store data in database
        $createOrder = Order::create($request->all());
        if($createOrder->wasRecentlyCreated) {
            foreach($cartProducts as $cartProduct) {
                OrderProduct::create([
                    'order_id'   =>  $createOrder->id,
                    'product_id' =>  $cartProduct->product_id,
                    'product_name'=> $cartProduct->product->name,
                    'quantity'    => $cartProduct->quantity,
                    'price'       => $cartProduct->price,
                    'total'       => bcmul($cartProduct->price, $cartProduct->quantity),
                ]);
                $cartProduct->product->update(['quantity'=>($cartProduct->product->quantity-$cartProduct->quantity)]);
            }
            OrderTotals::create([
                'order_id'  =>  $createOrder->id,
                'title'     =>  'Total paid',
                'value'     =>  bcmul($cartProduct->price, $cartProduct->quantity)
            ]);
            $checkCoupon = $this->checkCoupon($request->get('voucher'));
            if($checkCoupon) {
                OrderTotals::create([
                    'order_id'  =>  $createOrder->id,
                    'title'     =>  'Coupon: '.$checkCoupon->name,
                    'value'     =>  $checkCoupon->type == 'percent' ? $checkCoupon->value : $total/100*$checkCoupon->value
                ]);
                $createOrder->total = $createOrder->total-$checkCoupon->value;
                $createOrder->save();
                $this->useCoupon($checkCoupon);
            }
            Cart::forget();
            return redirect()->route('user.orders')->with('message', 'Your order was succesfully placed');
        }
    }

    public function checkCoupon($coupon) {
        if(Auth::user()->coupons->count() === 0) {
            return false;
        }
        $couponQuery = Auth::user()->coupons->where('code', $coupon);
        if($couponQuery->count() === 1) {
            if($couponQuery->first()->user_id === Auth::user()->id || $couponQuery->first()->user_id == null) {
                return $couponQuery->first();
            }
        }
        return false;
    }

    public function useCoupon(Coupon $coupon) {
        $coupon->used_times =+1;
        $coupon->state = 'inactive';
        $coupon->save();
    }
}
