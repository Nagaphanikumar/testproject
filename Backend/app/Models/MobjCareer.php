<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobjCareer extends Model
{
    use HasFactory;

    protected $table = 'm_obj_careers'; // Set the table name associated with this model

    protected $fillable = [
        'name',
        'email',
        'phonenumber',
        'uploadfile',
    ];
}
