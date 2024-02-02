<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'occurred_date' => $this->occurred_date->format('Y-m-d'),
            'currency' => $this->currency,
            'value' => floatval($this->value),
        ];
    }
}
