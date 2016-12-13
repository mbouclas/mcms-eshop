<?php

namespace Mcms\Eshop\Services;


use Config;
use LaravelLocalization;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class MoneyService
{
    protected $currency;
    protected $locale;

    public function __construct()
    {
        $this->currency = (Config::has('eshop.currency')) ? Config::get('eshop.currency') : 'EUR';
        $this->locale = LaravelLocalization::getCurrentLocaleRegional();
    }

    public function format($amount, $withSymbol = true)
    {
        if (is_float($amount)) {
            $amount = number_format($amount, 2, '.', '') * 100;//convert to int
        }

        $money = new Money($amount, new Currency($this->currency));
        $currencies = new ISOCurrencies();

        if ( ! $withSymbol) {
            $moneyFormatter = new DecimalMoneyFormatter($currencies);

            return $moneyFormatter->format($money);
        }

        $numberFormatter = new \NumberFormatter($this->locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}