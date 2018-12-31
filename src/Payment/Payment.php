<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2018-12-30
 * Time: 21:46
 */

namespace EasySwoole\WeChat\Payment;

class Payment
{
    private $appPay;
    private $h5Pay;
    private $jsApiPay;
    private $microPay;
    private $miniProgramPay;
    private $nativePay;

    /**
     * APP内支付
     * @return AppPay
     */
    public function appPay()
    {
        if (!isset($this->appPay)) {
            $this->appPay = new AppPay($this);
        }
        return $this->appPay;
    }

    /**
     * H5网页支付
     * @return H5Pay
     */
    public function h5Pay()
    {
        if (!isset($this->h5Pay)) {
            $this->h5Pay = new H5Pay($this);
        }
        return $this->h5Pay;
    }

    /**
     * 公众号JsApi支付
     * @return JsApiPay
     */
    public function jsApiPay()
    {
        if (!isset($this->jsApiPay)) {
            $this->jsApiPay = new JsApiPay($this);
        }
        return $this->jsApiPay;
    }

    /**
     * 付款码支付
     * @return MicroPay
     */
    public function microPay()
    {
        if (!isset($this->microPay)) {
            $this->microPay = new MicroPay($this);
        }
        return $this->microPay;
    }

    /**
     * 小程序支付
     * @return MiniProgramPay
     */
    public function miniProgramPay()
    {
        if (!isset($this->miniProgramPay)) {
            $this->miniProgramPay = new MiniProgramPay($this);
        }
        return $this->miniProgramPay;
    }

    /**
     * Native原生支付
     * @return NativePay
     */
    public function nativePay()
    {
        if (!isset($this->nativePay)) {
            $this->nativePay = new NativePay($this);
        }
        return $this->nativePay;
    }
}