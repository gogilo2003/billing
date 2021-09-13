<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function items()
    {
    	return $this->hasMany(InvoiceDetail::class,'invoice_id');
    }

    public function amount()
    {
    	$amount = 0;
    	foreach ($this->items as $item) {
    		$amount += $item->amount();
    	}
    	return $amount;
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}
