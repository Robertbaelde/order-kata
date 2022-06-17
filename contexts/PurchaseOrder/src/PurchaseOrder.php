<?php

namespace Kata\PurchaseOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'string';

    public $primaryKey = 'order_id';

    protected $guarded = [];
}
