<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2018-12-31
 * Time: 17:48
 */

namespace EasySwoole\WeChat\Payment;

class PaymentBase
{
    private $payment;

    function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function getPayment()
    {
        return $this->payment;
    }
}