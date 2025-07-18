<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Status;

class ServiceCategory extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    protected $table = 'service_categories';

    // Define which columns are mass assignable
    protected $fillable = [
        'name',
        'icon'
    ];

    public function statuses()
    {
        return $this->hasMany(Status::class, 'status_type', 'id');
    }
}
