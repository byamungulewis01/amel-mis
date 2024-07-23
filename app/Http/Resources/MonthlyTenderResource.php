<?php

namespace App\Http\Resources;

use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyTenderResource extends JsonResource
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
            'month' => Carbon::parse($this->month)->format('F Y'),
            'numberOfTenders' => Tender::where('monthly_tender_id', $this->id)->count(),
            'totalAmount' => Tender::where('monthly_tender_id', $this->id)->sum('tender_fees') + Tender::where('monthly_tender_id', $this->id)->sum('bid_security') + Tender::where('monthly_tender_id', $this->id)->sum('other_fees'),
            'amountUsed' => 0,
            'profit' => 0,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
