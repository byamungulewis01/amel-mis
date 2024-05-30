<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklyReport extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'week_number',
        'date_from',
        'date_to',
        'tender',
        'used_money',
        'transport',
        'accommodation',
        'status',
        'stored_by',
        'approved_by',
    ];
    public function details()
    {
        return $this->hasMany(WeeklyReportDetail::class,);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'stored_by');
    }
}
