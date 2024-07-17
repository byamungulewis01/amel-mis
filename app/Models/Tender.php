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
        'bid_security',
        'tender_fees',
        'description',
        'opening_date',
        'submitted_date',
        'documents',
        'status',
        'description',
        'sales_amount',
        'explainations',
        'stored_by',
        'approved_by',
        'closed_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'stored_by');
    }
}
