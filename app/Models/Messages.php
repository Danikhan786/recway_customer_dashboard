<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    // The table associated with the model
    protected $table = 'messages';

    // Disable automatic timestamps (since you've added 'created_at' manually)
    public $timestamps = false;
}
