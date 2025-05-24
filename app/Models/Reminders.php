<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{
    protected $fillable = [
      'title',
      'description',
      'date',
      'week_number',
      'day_number',
      'member_id',
    ];
}
