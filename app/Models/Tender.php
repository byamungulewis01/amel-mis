<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'tender_name',
        'request_amount',
        'sold_amount',
        'sales_amount',
        'request_for',
        'purchase_order_file',
        'estimated_badge_file',
        'status',
        'description',
        'stored_by',
        'approved_by',
        'closed_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'stored_by');
    }
}
