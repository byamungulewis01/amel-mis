<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'monthly_tender_id',
        'tender_name',
        'bid_security',
        'tender_fees',
        'other_fees',
        'description',
        'opening_date',
        'documents',
        'explainations',
        'stored_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'stored_by');
    }
    protected $casts = [
        'documents' => 'array', // Cast documents as array
    ];
}
