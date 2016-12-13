<?php

namespace Mcms\Eshop\StartUp;


use Mcms\Eshop\Menu\EshopInterfaceMenuConnector;
use Mcms\Eshop\Models\Page;
use Illuminate\Support\ServiceProvider;
use ModuleRegistry, ItemConnector;

class RegisterAdminPackage
{
    public function handle(ServiceProvider $serviceProvider)
    {
        ModuleRegistry::registerModule($serviceProvider->packageName . '/admin.package.json');

    }
}