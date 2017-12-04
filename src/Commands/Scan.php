<?php

namespace Helldar\Spammers\Commands;

use Carbon\Carbon;
use Helldar\Spammers\Models\Spammer as SpammerModel;
use Illuminate\Console\Command;

class Scan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search expiered IP-addresses and restore';

    /**
     * @var int
     */
    protected $expired = null;

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
        SpammerModel::where('expired_at', '<', Carbon::now())
            ->delete();
    }
}
