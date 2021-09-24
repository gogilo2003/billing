<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Services\SmsGatewayContract;
use Illuminate\Console\Command;

class ClientNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification/reminders to clients on account status';

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
    public function handle(SmsGatewayContract $sms)
    {
        $clients = Client::where('notification', 1)->get();

        $clients = $clients->filter(function ($client) {
            return $client->balance < 0 && $client->latest_cr_date->diffInDays(now()) >= 14;
        });

        foreach ($clients as $key => $client) {
            $sms->send(str_replace('+', '', $client->phone), view('sms.notification.client', compact('client'))->render());
        }

        return 0;
    }
}
