<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasCart() {
        return $this->hasOne(Cart::class, 'user_id')->where('state', 'active');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function coupons() {
        return $this->hasMany(Coupon::class, 'user_id')->where('state', 'active');
    }

    public function generatedLoyalityCoupons() {
        $usedCoupons = 0;
        foreach($this->hasMany(Order::class, 'user_id')->whereNotNull('generated_voucher') as $orderWithCoupon) {
            $coupon = Coupon::find($orderWithCoupon->generated_voucher);
            if($coupon) {
                $usedCoupons++;
            }
        }
        return $usedCoupons;
    }
}
