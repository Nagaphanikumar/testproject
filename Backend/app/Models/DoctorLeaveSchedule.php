<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorLeaveSchedule extends Model
{
    use HasFactory;
    protected $table = 'doctor_leave_schedule';

    protected $fillable = [
        'department_id',
        'doctor_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];
}
