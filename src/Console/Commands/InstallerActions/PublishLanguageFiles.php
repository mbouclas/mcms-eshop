<?php

namespace Mcms\Eshop\Console\Commands\InstallerActions;


use Illuminate\Console\Command;

/**
 * Class PublishLanguageFiles
 * @package Mcms\Eshop\Console\Commands\InstallerActions
 */
class PublishLanguageFiles
{
    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $command->call('vendor:publish', [
            '--provider' => 'Mcms\Eshop\EshopServiceProvider',
            '--tag' => ['lang'],
        ]);


        $command->call('core:translations:import');
        $command->comment('* Language files published');
    }
}