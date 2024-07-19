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
        $assignedTo = CashRequest::where('tender_id',$this->id)->first();
        return [
            'id' => $this->id,
            'tender_name' => $this->tender_name,
            'bid_security' => (int) $this->bid_security,
            'tender_fees' => (int) $this->tender_fees,
            'description' => $this->description,
            'opening_date' => $this->opening_date,
            'submitted_date' => $this->submitted_date,
            'documents' => $this->documents,
            'status' => $this->status,
            'sales_amount' => (int) $this->sales_amount,
            'explainations' => $this->explainations,
            'stored_by' => $this->stored_by,
            'stored_by_name' => User::find($this->stored_by)->name,
            'closed_by' => $this->closed_by,
            'closed_by_name' => @User::find($this->closed_by)->name,
            'assignedTo' => $assignedTo ? $assignedTo->user->name : 'Not Available',
            'created_at' => $this->created_at,
        ];
    }
}
