<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRequest extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'tender_id',
        'request_amount',
        'request_for',
        'purchase_order_file',
        'estimated_badge_file',
        'status',
        'description',
        'stored_by',
        'approvedOrRejected_by',
        'approveOrRejectDate',
        'comment',
        'isMoneyRecieved',
        'moneySentby',
        'moneyRecievedDate',
        'attachedDocument',
    ];
    public function tender()
    {
        return $this->belongsTo(Tender::class,);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'stored_by');
    }
}
