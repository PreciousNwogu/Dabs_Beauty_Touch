<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomServiceRequest extends Model
{
    protected $table = 'custom_service_requests';

    protected $fillable = [
        'name', 'email', 'phone', 'service', 'appointment_date', 'appointment_time', 'message', 'status'
    ];
}
