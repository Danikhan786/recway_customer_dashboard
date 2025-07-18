<?php
// app/Models/Staff.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardBillingDetails extends Model
{
    protected $table = 'standard_billing_details';
    public $timestamps = false;
    protected $fillable = [
        'cus_id', 
        'referenceperson', 
        'reference', 
        'comment', 
    ];

}
