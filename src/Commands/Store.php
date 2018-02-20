<?php

namespace Helldar\Spammers\Commands;

use Helldar\Spammers\Traits\ValidateIP;
use Illuminate\Console\Command;

class Store extends Command
{
    use ValidateIP;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new IP-address into spammers table';

    /**
     * @var int
     */
    protected $expired = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:store {ip : IP-address of spammer} {--e|expired=0 : User Ban Expired Hours}';

    /**
     * Create a new command instance.
     *
     * Clearing constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->ip = trim($this->argument('ip'));
        $this->expired = (int) $this->option('expired');

        if ($errors = $this->isIpValidateError()) {
            $this->errorsInConsole($errors);

            return;
        }

        $result = spammer($this->ip)
            ->expire($this->expired)
            ->store();

        $this->info($result);
    }
}
