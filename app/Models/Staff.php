<?php
// app/Models/Staff.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff'; // Specify the table name if it differs from the pluralized model name
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone', 
        'category', 
        'staff_members'
    ];

    // Optionally, you can define relationships or methods here if needed
}
