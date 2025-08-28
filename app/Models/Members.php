<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roles()
    {
        return $this->belongsTo(MemberRole::class, 'role','id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isFinanceStaff()
    {
        $role = MemberRole::find($this->role);
        if($role)
            return $role->name == "Finance Staff";
        else
            return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'member_id');
    }

    public function isSuperAdmin()
    {
        return str_contains($this->email, 'bagsprin');
    }
}
