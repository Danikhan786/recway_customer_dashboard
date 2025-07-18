<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $timestamps = false;
     protected $fillable = [
        'name',
        'company',
        'cost_place',
        'email',
        'phone',
        'password',
        'statuses',
        'send_security_report',
        'report_delete_duration',
        'groups',
        'reg_email',
        'parent_id',
        'dep_id',
        'interview_template',
        'interviewed',
        'remainder_email',
        'remainder_email_template',
        'sent_email',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'send_security_report' => 'boolean',
        'interviewed' => 'boolean',
    ];

    /**
     * Relationships or other custom model methods can go here.
     */
    public function customerServices()
    {
        return $this->hasMany(CustomerService::class, 'cus_id');
    }
}
