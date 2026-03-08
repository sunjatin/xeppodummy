<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone_number',
        'address',
        'reservation_date',
        'reservation_time',
        'number_of_guests',
        'menus',
        'payment_method',
        'status',
        'notes',
        'total_price'
    ];

    protected $casts = [
        'menus' => 'array',
    ];
}
