<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayments extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'order_payment_history';

}
