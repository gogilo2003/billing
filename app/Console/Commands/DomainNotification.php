<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Services\SmsGatewayContract;
use Illuminate\Console\Command;

class DomainNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track and send notification on domains close to expiry';

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
        $iv = collect(['8D', '15D', '30D', '60D', '90D']);

        $ivs = $iv->map(function ($i) {
            return date_create('now', new \DateTimeZone('Africa/Nairobi'))->add(new \DateInterval('P'.$i))->format('Y-m-d');
        });

        $domains = Domain::with('client')->whereDate('expires_on', now());

        foreach ($ivs as $key => $date) {
            $domains->union(Domain::with('client')->whereDate('expires_on', $date));
        }

        $table = $domains->orderBy('expires_on', 'ASC')
            ->get()
            ->each(function ($item) {
                $d1 = new \DateTime($item->expires_on);
                $d2 = new \DateTime('now');
                $diff = $d2->diff($d1);

                $message = 'This is a reminder that the domain '.$item->domain.' is scheduled to expire on '.date_create($item->expires_on)->format('j\<\s\u\p\>S\<\s\u\p\/\> F Y').' ('.$diff->days.' Days)';

                // $sms->send(str_replace('+', '', $client->phone), $message);
                dump($message);
            });

        return 0;
    }
}
