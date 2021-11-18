<?php

namespace App\Http\Resources;

use App\Http\Resources\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $items = $this->relationLoaded('items') ? InvoiceDetailResource::collection($this->items) : null;
        $amount = 0.00;

        foreach ($this->items as $item) {
            $amount += ($item->quantity * $item->price);
        };

        $client = $this->relationLoaded('client') ? new ClientResource($this->client) : $this->client_id;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => number_format($amount, 2),
            'created_at' => $this->created_at->format('D, j-M-Y'),
            'client' => $client,
            'items' => $items,
        ];
    }
}
