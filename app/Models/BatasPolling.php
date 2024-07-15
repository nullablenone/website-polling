<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatasPolling extends Model
{
    use HasFactory;
    protected $fillable = [
        'ip_address',
        'polls_count',
        'last_poll_date',
    ];
}
