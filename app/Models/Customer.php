<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Customer extends Model
{
    use HasFactory;

    // public $data = [];

    // public function getFill() : string
    // {
    //     foreach (Schema::getColumnListing('customers') as $col) {
    //         if (!in_array($col, ['id', 'created_at', 'updated_at'])) {
    //             $rules[] = $col;
    //         }
    //     }
    //     return trim($rules, ',');
    // }

    public function __construct()
    {
        $this->fillable(Schema::getColumnListing('customers'));
    }

    public function currencySymbol()
    {
        return $this->belongsTo(Currency::class, 'currency','code');
    }

    // protected $fillable = $data;
}
