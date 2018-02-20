<?php

namespace Helldar\Spammers\Commands;

use Helldar\Spammers\Traits\ValidateIP;
use Illuminate\Console\Command;

class Exists extends Command
{
    use ValidateIP;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check exists IP-address in spam table.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:exists {ip : IP-address}';

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

        if ($errors = $this->isIpValidateError()) {
            $this->errorsInConsole($errors);

            return;
        }

        if (spammer($this->ip)->exists()) {
            $this->info("IP-address {$this->ip} is exists.");

            return;
        }

        $this->info("IP-address {$this->ip} not exists.");
    }
}
