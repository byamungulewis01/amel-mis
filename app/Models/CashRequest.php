<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRequest extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'contract_id',
        'request_amount',
        'request_for',
        'purchase_order_file',
        'estimated_badge_file',
        'status',
        'stored_by',
        'approvedOrRejected_by',
        'approveOrRejectDate',
        'comment',
        'isMoneyRecieved',
        'moneySentby',
        'moneyRecievedDate',
    ];
    public function contact()
    {
        return $this->belongsTo(Contract::class,);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'stored_by');
    }
}
