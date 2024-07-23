<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyTender extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['month', 'status','user_id'];
}
