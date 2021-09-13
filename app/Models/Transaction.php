<?php

namespace App\Models;

use NumberFormatter;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['amount_word', 'receipt_no', 'receipt_date', 'cr', 'dr', 'balance', 'transaction_date'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getAmountWordAttribute()
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $f->format($this->amount);
    }

    public function getReceiptNoAttribute()
    {
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
    public function getReceiptDateAttribute()
    {
        return $this->created_at->format('j-M-Y');
    }
    public function getCrAttribute()
    {
        return $this->type == 'CR' ? $this->amount : 0;
    }

    public function getDrAttribute()
    {
        return $this->type == 'DR' ? $this->amount : 0;
    }

    public function getBalanceAttribute()
    {
        return $this->cr - $this->dr;
    }

    public function getTransactionDateAttribute()
    {
        return $this->created_at;
    }

}
