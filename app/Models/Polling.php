<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    use HasFactory;

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
