<?php

namespace Nidavellir\Installer\Commands;

use Illuminate\Console\Command;
use Nidavellir\Coingecko\CoingeckoCrawler;
use Nidavellir\Cube\Models\Ticker;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nidavellir:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Nidavellir for the first time';

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
        $this->info(
            "
 |\ | o  _|  _.     _  | | o ._
 | \| | (_| (_| \/ (/_ | | | |
"
        );

        $this->info('Deleting app/Models...');
        remove_directory(base_path('app/Models'));

        $this->info('Publishing nidavellir-cube assets...');
        $this->call('vendor:publish', [
            '--force' => true,
            '--provider' => 'Nidavellir\\Cube\\NidavellirCubeServiceProvider',
        ]);

        $this->info('Freshing database + initial seeding...');
        $this->call('migrate:fresh', [
            '--step',
        ]);

        $this->info('Uploading all Coingecko coins...');

        $data = CoingeckoCrawler::allTickers();

        foreach ($data->response() as $token) {
            Ticker::updateOrCreate(
                ['canonical' => $token['symbol']],
                ['name' => $token['name']]
            );
        }

        return 0;
    }
}
