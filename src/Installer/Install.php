<?php

namespace Mcms\Eshop\Installer;


use Mcms\Core\Services\Installer\InstallerContract;
use Illuminate\Console\Command;

class Install implements InstallerContract
{
    public $package = 'Eshop';

    public function run(Command $command, $commands = [])
    {

        $this->beforeRun();
        $this->afterRun();
        $command->call('eshop:install');
    }

    /**
     * The package name
     * @return string
     */
    public function packageName()
    {
        return $this->package;
    }

    /**
     * @return array
     */
    public function requiredInput()
    {
        return [
            'balls' => ['input' => 'A Ball']
        ];
    }

    /**
     * Executed just before the installer runs
     * @return $this
     */
    public function beforeRun()
    {
        event('installer.package.run.before',
            [$this->package . ' about to install']);

        return $this;
    }

    /**
     * Executed after the installer has run
     * @return $this
     */
    public function afterRun()
    {
        event('installer.package.run.after',
            [$this->package . ' was installed','info']);

        return $this;
    }
}