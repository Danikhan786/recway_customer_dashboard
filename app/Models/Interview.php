<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerService;

class Interview extends Model
{
    use HasFactory;

    protected $table = 'interviews'; // Specify the table name

    // Specify the fillable attributes based on the fields you provided
    protected $fillable = [
        'service_cat_id', 
        'title',          
        'desc',           
        'country',        
        'place',          
        'cost',           
    ];

    public function customerServices()
    {
        return $this->hasMany(CustomerService::class, 'service_id');
    }
}
