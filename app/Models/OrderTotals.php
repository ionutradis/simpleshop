<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTotals extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'title',
        'value',
    ];
}
