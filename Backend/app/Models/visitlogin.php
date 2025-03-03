<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visitlogin extends Model
{
    use HasFactory;
    protected $table = 'visitlogin'; // Set the table name associated with this model

    protected $fillable = [
       
        'id',
        'username',
        'password',
    ];
    
}
