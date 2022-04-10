<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $fillable = ['email','appointment_id'];

    public function appointment()
  {
    return $this->belongsTo(Appointment::class);
  }
}
