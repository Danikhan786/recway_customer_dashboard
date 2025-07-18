<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLogs extends Model
{
    protected $table = 'email_logs'; 

    protected $fillable = [
        'meta',
        'status',
        'error_message',
        'timestamp'
    ];
    public $timestamps = false;
}
