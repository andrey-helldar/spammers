<?php

namespace Helldar\Spammers\Commands;

use Helldar\Spammers\Traits\Spammer;
use Helldar\Spammers\Traits\ValidateIP;
use Illuminate\Console\Command;

class Exists extends Command
{
    use ValidateIP, Spammer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:exists {ip : IP-address of spammer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check exists IP-address in spam table.';

    /**
     * @var string
     */
    protected $ip;

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
     *
     * @return mixed
     */
    public function handle()
    {
        $this->ip = trim($this->argument('ip'));

        if ($errors = $this->isIpValidateError()) {
            $this->errorsInConsole($errors);

            return;
        }

        if ($is_exist = $this->spammer()->exists()) {
            $this->info("IP-address {$this->ip} is exists.");

            return;
        }

        $this->info("IP-address {$this->ip} not exists.");
    }
}
