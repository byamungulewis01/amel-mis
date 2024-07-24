<?php

namespace App\Http\Resources;

use App\Models\Contract;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            'name' => Contract::find($this->contract_id)->name,
            'request_amount' => (int) $this->request_amount,
            'request_for' => $this->request_for,
            'purchase_order_file' => $this->purchase_order_file,
            'estimated_badge_file' => $this->estimated_badge_file,
            'status' => $this->status,
            'stored_by' => $this->stored_by,
            'stored_by_name' => User::find($this->stored_by)->name,
            'approvedOrRejected_by' => $this->approvedOrRejected_by,
            'approvedOrRejected_by_name' => @User::find($this->approvedOrRejected_by)->name,
            'approveOrRejectDate' => $this->approveOrRejectDate,
            'comment' => $this->comment,
            'isMoneyRecieved' => $this->isMoneyRecieved,
            'moneySentby' => $this->moneySentby,
            'moneyRecievedDate' => $this->moneyRecievedDate,
            'created_at' => $this->created_at,
        ];
    }
}
