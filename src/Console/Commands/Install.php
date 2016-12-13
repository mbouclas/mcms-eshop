<?php

namespace Mcms\Eshop\Console\Commands;

/**
 * What i do :
 * 1. Publish my settings
 * 2. Publish my assets
 * 3. Publish my views
 * 5. Migrate my DB
 * 6. Seed my DB with defaults
 *
 * If you provide me with a provision file, i will make some changes to the config file of the application
 */

use Mcms\Core\Helpers\Composer;
use Mcms\Eshop\Console\Commands\InstallerActions\ApplyProvisionSettings;
use Mcms\Eshop\Console\Commands\InstallerActions\MigrateDataBase;
use Mcms\Eshop\Console\Commands\InstallerActions\PublishAssets;
use Mcms\Eshop\Console\Commands\InstallerActions\PublishSettings;
use Mcms\Eshop\Console\Commands\InstallerActions\PublishViews;
use Mcms\Eshop\Console\Commands\InstallerActions\SeedDataBase;
use Illuminate\Console\Command;
use Event;
use \File;


/**
 * Class Install
 * @package Mcms\Eshop\Console\Commands
 */
class Install extends Command
{
    /**
     * @var array
     */
    protected $actions = [
        'settings' => PublishSettings::class,
        'assets' => PublishAssets::class,
        'views' => PublishViews::class,
        'migrate' => MigrateDataBase::class,
        'seed' => SeedDataBase::class,
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eshop:install {provisionFile?} {--action=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs this module';

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
        //load composer
        $composer = new Composer();
        $command = "php artisan eshop:refreshAssets";

        if ( ! in_array($command, $composer->contents['scripts']['post-update-cmd'])){
            $this->comment("adding command into composer");
            $composer->contents['scripts']['post-update-cmd'][] = $command;
            $composer->save();
            $this->info('composer updated');
        }

        $this->registerEvents();
        $this->info('Eshop package is starting the installation');
        $this->line('--------------');
        $actions = array_keys($this->actions);

        //Run selective actions. Must be in the format --action="migrate seed assets"
        if ($this->option('action')){
            $actions = explode(" ", $this->option('action'));
        }

        /**
         * Run all actions
         */
        foreach ($actions as $action){
            (new $this->actions[$action]())->handle($this);
        }


        if ($this->argument('provisionFile')){
            (new ApplyProvisionSettings())->handle($this,$this->argument('provisionFile'));
        }

        //add the post install command to be able to refresh assets

        
        $this->info('Eshop, all Done');
        $this->info('---------------');
        $this->line('');
    }

    /**
     *
     */
    private function registerEvents()
    {
        Event::listen('installer.eshop.run.before', function ($msg, $type = 'comment'){
            $this->{$type}($msg);
        });

        Event::listen('installer.eshop.run.after', function ($msg, $type = 'comment'){
            $this->{$type}($msg);
        });
    }
}
