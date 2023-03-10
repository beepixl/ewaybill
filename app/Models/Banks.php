<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{   
    use HasFactory;
    protected $fillable = ['account_name','account_no','ifsc_code','bank_name','branch_name','swift_code'];
}
