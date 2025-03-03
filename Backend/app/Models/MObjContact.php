<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MObjContact extends Model
{
    use HasFactory;

    protected $table = 'm_obj_contacts'; // Set the table name associated with this model

    protected $fillable = [
        'id',
        'name',
        'email',
        'subject',
        'message',
    ];
    protected $primaryKey = 'id';

}
