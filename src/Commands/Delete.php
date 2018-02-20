<?php

namespace Helldar\Spammers\Commands;

use Helldar\Spammers\Traits\ValidateIP;
use Illuminate\Console\Command;

class Delete extends Command
{
    use ValidateIP;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove IP-address from spammers table';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:delete {ip : IP-address of spammer}';

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

        $result = \spammer($this->ip)->delete();

        $this->info($result);
    }
}
