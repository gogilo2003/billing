<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $appends = ['balance', 'latest_cr_date', 'latest_dr_date', 'latest_transaction_date'];

    public function accounts()
    {
    	return $this->hasMany(Account::class);
    }

    public function invoices()
    {
    	return $this->hasMany(Invoice::class);
    }

    public function cr()
    {
        $cr = 0;
        foreach ($this->accounts as $account) {
            $cr += $account->cr();
        }
        return $cr;
    }

    public function dr()
    {
        $dr = 0;
        foreach ($this->accounts as $account) {
            $dr += $account->dr();
        }
        return $dr;
    }

    public function balance($formated=true)
    {
    	$balance = 0;
    	foreach ($this->accounts as $account) {
    		$balance += $account->balance();
    	}
    	return $formated ? number_format($balance,2) : $balance;
    }

    public function getBalanceAttribute()
    {
        return $this->balance(false);
    }

    public function getPhoneAttribute($value)
    {
        return clean_isdn($value);
    }

    public function getLatestCrDateAttribute()
    {
        $accounts = $this->accounts
            ->sortByDateDesc('latest_cr_date')
            ->pluck('latest_cr_date');

        return $accounts[0];
    }

    public function getLatestDrDateAttribute()
    {
        $accounts = $this->accounts
            ->sortByDateDesc('latest_dr_date')
            ->pluck('latest_dr_date');

        return $accounts[0];
    }

    public function getLatestTransactionDateAttribute()
    {
        $accounts = $this->accounts
            ->sortByDateDesc('latest_transaction_date')
            ->pluck('latest_transaction_date');

        return $accounts[0];
    }

}
