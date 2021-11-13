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
        $client = $this->relationLoaded('client') ? new ClientResource($this->client) : $this->client_id;
        $amount = 0.00;
        foreach($items as $item){
            $amount += ($item->quantity * $item->price);
        };

        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $amount,
            'created_at' => $this->created_at,
            'client' => $client,
            'items' => $items,
        ];
    }
}
