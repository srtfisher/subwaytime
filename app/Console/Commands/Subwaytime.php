<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subwaytime as SubwaytimeApp;

class Subwaytime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subwaytime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve the latest subway times';

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
        $app = new SubwaytimeApp;
        $app->get();
        $this->info('DONE');
    }
}
