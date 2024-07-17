<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory ,HasUuids;
    protected $fillable = [
        'name',
        'contract_number',
        'description',
        'value',
        'signed_date',
        'status',
        'type',
        'stored_by',
    ];
}
