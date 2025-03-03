<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctors'; // Set the table name associated with this model

    protected $fillable = [
        'parent_obj_id',
        'obj_id',
        'Speciality',
        'Experience',
        'Qualification',
        'Gender',
        'role',
        'information',
    ];
}
