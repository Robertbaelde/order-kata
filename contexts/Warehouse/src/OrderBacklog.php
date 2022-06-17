<?php

namespace Kata\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBacklog extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'string';

    public $primaryKey = 'order_id';

    protected $guarded = [];
}
