<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;

class Status extends Model
{
    use HasFactory;

    // Specify the table associated with the model (optional if it follows Laravel's naming convention)
    protected $table = 'statuses';

    // Define the fillable properties for mass assignment
    protected $fillable = [
        'variable',
        'status',
        'status_detail',
        'status_icon',
        'color',
        'email_to',
        'status_type',
    ];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'status_type', 'id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'status', 'id'); // Adjust the foreign key and local key as needed
    }
    public function allowedEmails()
{
    return $this->hasOne(AllowedEmails::class, 'status_id')->where('cus_id', auth()->id());
}
}
