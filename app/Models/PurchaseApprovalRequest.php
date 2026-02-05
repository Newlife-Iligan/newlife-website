<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseApprovalRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array',
    ];
    protected $guarded = [];
}
