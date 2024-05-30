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
        'item',
        'quoting_price',
        'market_price',
        'status',
        'stored_by',
    ];
}
