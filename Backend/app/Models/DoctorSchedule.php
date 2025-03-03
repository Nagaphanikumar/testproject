<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;
    protected $table = 'doctor_schedule'; // Set the table name associated with this model

    protected $fillable = [
        'obj_id',
        'day',
        'start_time',
        'end_time',
    ];
}
