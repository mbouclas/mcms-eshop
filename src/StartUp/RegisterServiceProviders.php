<?php

namespace Mcms\Eshop\StartUp;
use App;

/**
 * Register your dependencies Service Providers here
 * Class RegisterServiceProviders
 * @package Mcms\Eshop\StartUp
 */
class RegisterServiceProviders
{
    /**
     *
     */
    public function handle()
    {
        App::register(\Darryldecode\Cart\CartServiceProvider::class);
    }
}