<?php

namespace Mcms\Eshop\Services;


use Mcms\Products\Models\Product;

class EshopService
{
    public $cart;
    public $product;
    public $order;
    public $coupon;
    public $discount;
    public $money;
    protected $config;

    public function __construct($cart = null)
    {
        $this->config = \Config::get('eshop');
        $this->product = new Product();
        $this->cart = new CartService($cart);
        $this->order = new OrderService();
        $this->discount = new DiscountService();
        $this->coupon = new CouponService();
        $this->money = new MoneyService();
    }
}