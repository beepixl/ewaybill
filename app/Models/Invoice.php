<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function billProducts()
    {
        return $this->hasMany(Product::class, 'invID');
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayments::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customerId');
    }
}
