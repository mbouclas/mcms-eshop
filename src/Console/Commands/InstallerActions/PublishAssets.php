<?php

namespace Mcms\Eshop\Console\Commands\InstallerActions;


use Illuminate\Console\Command;

/**
 * Class PublishAssets
 * @package Mcms\Eshop\Console\Commands\InstallerActions
 */
class PublishAssets
{
    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $command->call('vendor:publish', [
            '--provider' => 'Mcms\Eshop\EshopServiceProvider',
            '--tag' => ['public'],
        ]);

        $command->call('vendor:publish', [
            '--provider' => 'Mcms\Eshop\EshopServiceProvider',
            '--tag' => ['assets'],
        ]);

        $command->call('vendor:publish', [
            '--provider' => 'Mcms\Eshop\EshopServiceProvider',
            '--tag' => ['admin-package'],
        ]);

        $command->comment('* Assets published');
    }
}