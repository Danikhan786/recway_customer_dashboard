<?php

namespace App\Models;

use App\Models\Interview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;

    protected $table = 'customer_services';

    protected $primaryKey = 'id'; 

    
    public $incrementing = false; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'cus_id',
        'service_id',
        'service_cost' 
    ];  

    public function customer()
    {
        return $this->belongsTo(User::class, 'cus_id');
    }

    public function interview()
    {
        return $this->belongsTo(Interview::class, 'service_id');
    }
}
