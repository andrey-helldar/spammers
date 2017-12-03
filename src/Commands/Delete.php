<?php

namespace Helldar\Spammers\Commands;

use Illuminate\Console\Command;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy IP-address from spam-table.';

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
        return spammer('127.0.0.1')->delete();
    }
}
