<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderForms extends Model
{
    // The table associated with the model
    protected $table = 'order_forms';

    // The attributes that are mass assignable
    protected $fillable = ['cus_id', 'service_id', 'form'];

    // Disable automatic timestamps (since you've added 'created_at' manually)
    public $timestamps = false;
}
