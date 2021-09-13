<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Account extends Model
{

    protected $appends = ['cr', 'dr', 'balance', 'latest_cr_date', 'latest_dr_date', 'latest_transaction_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function cr()
    {
        return $this->transactions()->where('type', '=', 'CR')->get()->sum('amount');
    }

    public function dr()
    {
        return $this->transactions()->where('type', '=', 'DR')->get()->sum('amount');
    }

    public function balance()
    {
        return $this->cr() - $this->dr();
    }

    public function getCrAttribute($value)
    {
        return $this->cr();
    }

    public function getDrAttribute($value)
    {
        return $this->dr();
    }

    public function getBalanceAttribute($value)
    {
        return $this->balance();
    }

    public function getLatestCrDateAttribute()
    {
        $transactions = $this->transactions
            ->where('type', 'CR')
            ->sortByDateDesc('transaction_date')
            ->pluck('transaction_date');

        return $transactions[0];
    }

    public function getLatestDrDateAttribute()
    {
        $transactions = $this->transactions
            ->where('type', 'DR')
            ->sortByDateDesc('transaction_date')
            ->pluck('transaction_date');

        return $transactions[0];
    }

    public function getLatestTransactionDateAttribute()
    {
        $transactions = $this->transactions
            ->sortByDateDesc('transaction_date')
            ->pluck('transaction_date');

        return $transactions[0];
    }
}
