<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'order_id',
        'vasc_id',
        'security',
        'name',
        'surname',
        'email',
        'phone',
        'place',
        'country',
        'cv',
        'referensperson',
        'reference',
        'comment',
        'note',
        'cus_id',
        'staff_id',
        'interview_id',
        'status',
        'date',
        'reported',
        'invoice_sent',
        'invoice_date',
        'economy',
        'criminal_record',
        'social',
        'background_checked',
        'created',
        'booked',
        'expired',
        'background_check_date',
        'delivery_date',
        'report',
        'report_status',
        'interview_report',
        'dep_user',
        'dep_id',
        'cus_qs_ans',
        'meta_data',
        'reported_to_sm',
        'reported_to_sm_on',
        'interview_template',
        'meta_info',
        'service_cost',
        'travel_cost'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public $timestamps = false;

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
