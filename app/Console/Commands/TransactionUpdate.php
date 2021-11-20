<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Console\Command;

class TransactionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaction update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            $transaction = Transaction::where('particulars', $invoice->name)
                ->where('amount', $invoice->amount())
                ->where('type', 'DR')
                ->first();

            if ($transaction) {
                $transaction->invoice_id = $invoice->id;
                $transaction->save();
            }
        }
        return Command::SUCCESS;
    }
}
