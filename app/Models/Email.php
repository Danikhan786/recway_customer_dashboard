<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails'; 

    protected $fillable = [
        'user_type',
        'user_name',
        'order_id',
        'msg_type',
        'text',
        'email',
        'subject',
        'email_delay'
    ];
    public $timestamps = false;
}
