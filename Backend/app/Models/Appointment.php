<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'booking_id',
        'name',
        'phone',
        'gender',
        'age',
        'city',
        'appointment_date',
        'department',
        'doctor',
        'time',
        'address',
        'reject_time',
        'username',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($appointment) {
        // Generate a unique booking_id starting with "DVC" followed by 10 numbers
        $bookingId = 'DVC' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);

        // Check if the generated booking_id already exists and regenerate if needed
        while (static::where('booking_id', $bookingId)->exists()) {
            $bookingId = 'DVC' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
        }

        $appointment->booking_id = $bookingId;
    });
}

}
