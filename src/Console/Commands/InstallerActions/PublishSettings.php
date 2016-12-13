<?php

namespace Mcms\Eshop\Console\Commands\InstallerActions;


use Illuminate\Console\Command;


/**
 * @example php artisan vendor:publish --provider="Mcms\Eshop\EshopServiceProvider" --tag=config
 * Class PublishSettings
 * @package Mcms\Eshop\Console\Commands\InstallerActions
 */
class PublishSettings
{
    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $command->call('vendor:publish', [
            '--provider' => 'Mcms\Eshop\EshopServiceProvider',
            '--tag' => ['config'],
        ]);

        $command->comment('* Settings published');
    }
}