<?php

namespace Mcms\Eshop\Services;


use Cart;
use Darryldecode\Cart\CartCondition;

/**
 * Class CartService
 * @package Mcms\Eshop\Services
 */
class CartService
{
    protected $money;
    protected $cart;
    protected $defaultCartName = 'cart';

    public function __construct($cartName = null)
    {
        $cartName = ( ! $cartName) ? $this->defaultCartName : $cartName;
        $this->money = new MoneyService();
        $this->cart = app($cartName);
    }

    public function __call($method, array $args = [])
    {
        if (in_array($method, get_class_methods(\Darryldecode\Cart\Cart::class))) {
            return call_user_func_array([$this->cart, $method], $args);
        }
    }
    /**
     * add item to the cart, it can be an array or multi dimensional array
     *
     * @param string|array $id
     * @param string $name
     * @param float $price
     * @param int $quantity
     * @param array $attributes
     * @param CartCondition|array $conditions
     * @return $this
     */
    public function add($id, $name = null, $price = null, $quantity = null, $attributes = [], $conditions = [])
    {
        $this->cart->add($id, $name, $price, $quantity, $attributes, $conditions);

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function remove($id)
    {
        $this->cart->remove($id);

        return $this;
    }

    public function update($id, $data)
    {
        $this->cart->update($id, $data);

        return $this;
    }
    
    /**
     * @param $id
     * @param array $condition
     * @return $this
     */
    public function addConditionToItem($id, array $condition)
    {
        $this->cart->addItemCondition($id, new CartCondition($condition));

        return $this;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function addConditionToCart(array $condition)
    {
        $this->cart->condition(new CartCondition($condition));

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->cart->get($id);
    }

    /**
     * @return \Darryldecode\Cart\CartCollection
     */
    public function contents()
    {
        return $this->cart->getContent();
    }

    /**
     * @return float
     */
    public function total($withSymbol = true)
    {
        return $this->money->format($this->cart->getTotal(), $withSymbol);
    }

    /**
     * @return float
     */
    public function subTotal($withSymbol = true)
    {
        return $this->money->format($this->cart->getSubTotal(), $withSymbol);
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->cart->clear();

        return $this;
    }
}