<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    // The table associated with the model
    protected $table = 'history';

    // The attributes that are mass assignable
    protected $fillable = ['order_id', 'desc', 'date_time','comment'];

    // Disable automatic timestamps (since you've added 'created_at' manually)
    public $timestamps = false;
}
