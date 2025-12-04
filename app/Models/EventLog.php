<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'message',
        'ip_address',
        'user_agent',
        'user_id'
    ];
}
