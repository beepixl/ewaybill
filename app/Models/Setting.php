<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'fromGstin',
        'fromTrdName',
        'fromAddr1',
        'fromAddr2',
        'fromPlace',
        'fromPincode',
        'actFromStateCode',
        'fromStateCode',
        'invPrefix',
        'invNoStart',
        'logoPath',
        'appName',
        'timezone',
        'appEnv',
        'appDebug',
        'dbConn',
        'storageDisk',
        'mailHost',
        'mailPort',
        'mailEnc',
        'mailUnm',
        'mailPwd',
        'mailFrom',
        'mailName',
    ];
}
