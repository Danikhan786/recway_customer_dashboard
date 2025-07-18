<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer; 

class Reviewer extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural of the model name
    protected $table = 'reviewers';

    // Define which fields can be mass assignable (optional)
    protected $fillable = ['cus_id', 'email', 'password'];
    public $timestamps = false;

    // If you are using Laravel's default timestamps, no need to define anything for `created_at` and `updated_at`
    // But if the table does not have timestamps, use:
    // public $timestamps = false;

    /**
     * Define a relationship to the customer (if there is a `Customer` model/table).
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cus_id');
    }
}
