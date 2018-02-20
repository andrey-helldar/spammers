<?php

namespace Helldar\Spammers\Commands;

use Helldar\Spammers\Traits\ValidateIP;
use Illuminate\Console\Command;

class Restore extends Command
{
    use ValidateIP;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore IP-address in spammers table';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:restore {ip : IP-address}';

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

        $result = spammer($this->ip)->restore();

        $this->info($result);
    }
}
