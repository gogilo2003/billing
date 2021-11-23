<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    public function items()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    /**
     * Get all of the transactions for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
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

    /**
     * Get the account that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
