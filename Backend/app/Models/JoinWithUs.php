<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinWithUs extends Model
{
    use HasFactory;
    
    protected $table = 'join_with_us';

    protected $fillable = [
        'name',
        'mob_number',
        'email_id',
        'address',
        'with_us_msg',
    ];
}
