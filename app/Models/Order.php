<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'street',
        'street_number',
        'postcode',
        'country_code',
        'telephone',
        'voucher',
        'total',
        'generated_voucher',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
