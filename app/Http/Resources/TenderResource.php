<?php

namespace App\Http\Resources;

use App\Models\CashRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderResource extends JsonResource
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
            'tender_name' => $this->tender_name,
            'bid_security' => (int) $this->bid_security,
            'tender_fees' => (int) $this->tender_fees,
            'other_fees' => (int) $this->other_fees,
            'description' => $this->description,
            'opening_date' => $this->opening_date,
            'total_amount'=> $this->bid_security + $this->tender_fees + $this->other_fees,
            'documents' => $this->documents,
            'stored_by' => $this->stored_by,
            'stored_by_name' => User::find($this->stored_by)->name,
            'created_at' => $this->created_at,
        ];
    }
}
