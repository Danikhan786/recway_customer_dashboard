<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    // The table associated with the model
    protected $table = 'otp_verification';

    // The attributes that are mass assignable
    protected $fillable = ['email', 'otp', 'date_time'];

    // Disable automatic timestamps (since you've added 'created_at' manually)
    public $timestamps = false;
}
