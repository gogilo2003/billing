<?php

namespace App\Services;

use App\Models\Quotation;
use App\Models\QuotationItem;

class QuotationService
{
    /**
     * Store a new Quotation
     *
     * @param int $client_id
     * @param int $user_id
     * @param int $validity
     * @param array $items
     * @param String $description
     *
     * @return \App\Models\Quotation
     */
    function store(int $client_id, int $user_id, int $validity, array $items,  String $description): Quotation
    {
        $quotation = new Quotation();
        $quotation->client_id = $client_id;
        $quotation->user_id = $user_id;
        $quotation->validity = $validity;
        $quotation->items = $items;
        $quotation->description = $description;
        $quotation->save();

        foreach ($items as $item) {
            $quote = new QuotationItem();
            $quote->quotation_id = $item['quotation_id'];
            $quote->particulars = $item['particulars'];
            $quote->quantity = $item['quantity'];
            $quote->price = $item['price'];
            $quote->unit = $item['unit'];
            $quotation->items()->attach($quote);
        }

        return $quotation;
    }

    /**
     * Update existing Quotation
     *
     * @param int $id
     * @param int $client_id
     * @param int $user_id
     * @param int $validity
     * @param array $items
     * @param String $description
     *
     * @return \App\Models\Quotation
     */
    function update(int $id, int $client_id, int $user_id, int $validity, array $items, string $description)
    {
        $quotation = Quotation::find($id);
        $quotation->client_id = $client_id;
        $quotation->user_id = $user_id;
        $quotation->validity = $validity;
        $quotation->items = $items;
        $quotation->description = $description;
        $quotation->save();

        foreach ($items as $item) {
            $quote = new QuotationItem();
            $quote->quotation_id = $item['quotation_id'];
            $quote->particulars = $item['particulars'];
            $quote->quantity = $item['quantity'];
            $quote->price = $item['price'];
            $quote->unit = $item['unit'];
            $quotation->items()->attach($quote);
        }

        return $quotation;
    }
}