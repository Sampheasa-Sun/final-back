<?php

// app/Models/AdminLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table = 'admin_logs';

    protected $fillable = [
        'admin_id',
        'action',
        'target_type',
        'target_id',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // Optional, if you don't use updated_at
}
