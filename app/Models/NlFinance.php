<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NlFinance extends Model
{
    use HasFactory;
    protected $table = 'nl_finance';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Handle CV number generation for cv_only and cv_ar types
            if (in_array($model->form_type, ['cv_only', 'cv_ar']) && empty($model->cv_number)) {
                $cvDate = Carbon::parse($model->cv_date);
                $month = $cvDate->format('m');
                $year = $cvDate->format('Y');

                // Get the last CV number for this year and month
                $lastCvNumber = static::where('cv_number', 'like', "CV{$year}-{$month}-%")
                    ->orderBy('cv_number', 'desc')
                    ->first();

                if ($lastCvNumber) {
                    // Extract the sequence number and increment it
                    $lastSequence = (int) substr($lastCvNumber->cv_number, -3);
                    $nextSequence = $lastSequence + 1;
                } else {
                    $nextSequence = 1;
                }

                // Format with leading zeros
                $sequenceNumber = str_pad($nextSequence, 3, '0', STR_PAD_LEFT);
                $model->cv_number = "CV{$year}-{$month}-{$sequenceNumber}";
            }

            // Handle AR number generation for ar_only and cv_ar types
            if (in_array($model->form_type, ['ar_only', 'cv_ar']) && empty($model->ar_number)) {
                $arDate = Carbon::parse($model->ar_date);
                $month = $arDate->format('m');
                $year = $arDate->format('Y');

                // Get the last AR number for this year and month
                $lastArNumber = static::where('ar_number', 'like', "AR{$year}-{$month}-%")
                    ->orderBy('ar_number', 'desc')
                    ->first();

                if ($lastArNumber) {
                    // Extract the sequence number and increment it
                    $lastSequence = (int) substr($lastArNumber->ar_number, -3);
                    $nextSequence = $lastSequence + 1;
                } else {
                    $nextSequence = 1;
                }

                // Format with leading zeros
                $sequenceNumber = str_pad($nextSequence, 3, '0', STR_PAD_LEFT);
                $model->ar_number = "AR{$year}-{$month}-{$sequenceNumber}";
            }
        });
    }
}
