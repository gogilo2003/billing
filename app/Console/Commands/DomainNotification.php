<?php

namespace App\Console\Commands;

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
    public function handle()
    {
        $this->comment('Domain Notification');

        return 0;
    }
}
