<?php

namespace Mcms\Eshop\StartUp;


use App;
use Illuminate\Support\ServiceProvider;

/**
 * Register your Facades/aliases here
 * Class RegisterFacades
 * @package Mcms\Eshop\StartUp
 */
class RegisterFacades
{
    /**
     * @param ServiceProvider $serviceProvider
     */
    public function handle(ServiceProvider $serviceProvider)
    {

        /**
         * Register Facades
         */
        $facades = \Illuminate\Foundation\AliasLoader::getInstance();
        $facades->alias('Cart', \Darryldecode\Cart\Facades\CartFacade::class);
        
    }
}