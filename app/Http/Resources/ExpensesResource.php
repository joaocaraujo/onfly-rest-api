<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpensesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'date' => $this->date->format('Y-m-d'),
            'amount' => $this->amount,
            'user' => $this->user->only(['id', 'name', 'email']),
        ];
    }
}
