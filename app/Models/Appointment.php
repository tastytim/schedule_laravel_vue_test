<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'url',
        'date_start',
        'date_end',
        'is_all_day',
        'is_notificate',
        'user_id'
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function emails(){
        return $this->hasMany(Emails::class, 'appointment_id');
    }
}
