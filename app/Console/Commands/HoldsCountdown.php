<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HoldsCountdown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:holdscountdown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Countdown holds days';

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
     * @return mixed
     */
    public function handle()
    {
        $class = '\\App\\Jobs\\HoldsCountdown';
        dispatch(new $class());
    }
}
