<?php

namespace Helldar\Spammers\Commands;

use Illuminate\Console\Command;

class Amnesty extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Amnesty for IP-address';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:amnesty';

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
        $result = spammer()->amnesty();

        $this->info($result);
    }
}
