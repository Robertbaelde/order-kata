<?php

namespace Kata\Payments;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'method' => PaymentMethod::class
    ];

    public $keyType = 'string';
    public $incrementing = false;

    protected $primaryKey = 'reference';


}
