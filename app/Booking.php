<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_date', 'customer_id', 'customer_name', 'car_number', 'duration', 'note', 'verification_number', 'booking_status', 'total_amount',
    ];

    protected $casts = [
        'booking_date' => 'datetime:Y-m-d',
    ];

    protected $hidden = ['pivot'];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
