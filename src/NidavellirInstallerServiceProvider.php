<?php

namespace Nidavellir\Installer;

use Illuminate\Support\ServiceProvider;
use Nidavellir\Installer\Commands\InstallCommand;

class NidavellirInstallerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerCommands();
    }

    public function register()
    {
        //
    }

    protected function registerCommands(): void
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }
}
