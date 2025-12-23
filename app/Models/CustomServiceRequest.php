<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomServiceRequest extends Model
{
    protected $table = 'custom_service_requests';

    protected $fillable = [
        'name', 'email', 'phone', 'service', 'appointment_date', 'appointment_time', 'message', 'status',
        'service_category', 'braid_size', 'hair_length', 'budget_range', 'urgency',
        'style_preferences', 'special_requirements', 'reference_image'
    ];
}
