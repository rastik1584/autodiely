<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install project run migrations npm and build vue';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Run migration');
        Artisan::call('migrate');
        $this->info('Run npm install');
        exec('npm i');
        $this->info('Run npm dev build');
        exec('npm run dev');
        $this->info('Project is successfully installed');
        return Command::SUCCESS;
    }
}
