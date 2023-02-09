<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePerforma extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'invoice_performa';
    protected $guarded = [];

    public function billProducts()
    {
        return $this->hasMany(Product::class, 'invID');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bankId');
    }
}
