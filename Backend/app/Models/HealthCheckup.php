<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCheckup extends Model
{
    protected $table = 'health_checkups';

    protected $fillable = [
        'name', 'phone', 'age', 'city','address' ,'booking_id','date', 'department', 'gender', 'cost','rejectedcost'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->booking_id = 'DVC' . rand(1000000000, 9999999999);
        });
    }
}
