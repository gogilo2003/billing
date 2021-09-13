<?php

namespace App\Console\Commands;

use App\Models\Sms;
use Illuminate\Console\Command;
use App\Services\SmsGatewayContract;

class SmsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Continously check status of sent messages and update';

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
    public function handle(SmsGatewayContract $smsGateway)
    {
        $messages = Sms::where('status','!=','Sent')->get();
        foreach($messages as $message){
            $smsGateway->update($message->message_id);
        }
        return 0;
    }
}
