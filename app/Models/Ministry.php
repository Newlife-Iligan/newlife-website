<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function members()
    {
        return $this->hasMany(Members::class, 'ministry_id');
    }
}
