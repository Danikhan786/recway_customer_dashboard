<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllowedEmails extends Model
{
    protected $table = 'allowed_emails'; 
    protected $fillable = [
        'cus_id',
        'status_id',
        'allowed' 
    ];  
    public $timestamps = false;
}
 