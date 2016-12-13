<?php

namespace Mcms\Eshop\Console\Commands\InstallerActions;


use Illuminate\Console\Command;

/**
 * Class PublishViews
 * @package Mcms\Eshop\Console\Commands\InstallerActions
 */
class PublishViews
{
    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $command->call('vendor:publish', [
            '--provider' => 'Mcms\Eshop\EshopServiceProvider',
            '--tag' => ['views'],
        ]);
        
        $command->comment('* Views published');
    }
}