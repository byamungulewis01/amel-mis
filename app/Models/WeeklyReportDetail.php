<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyReportDetail extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'weekly_report_id',
        'date',
        'day_name',
        'activities',
        'comment',
        'hours',
    ];
}
