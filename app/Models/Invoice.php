<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'start_date',
        'end_date',
        'discount',
        'total',
        'paid_at',
        'payment_coupon_id',
        'company_id',
    ];
}
