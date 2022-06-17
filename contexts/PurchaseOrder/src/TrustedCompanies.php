<?php

namespace Kata\PurchaseOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrustedCompanies extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'string';

    public $primaryKey = 'company_id';

    protected $guarded = [];
}
