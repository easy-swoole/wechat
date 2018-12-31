<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2018-12-31
 * Time: 17:08
 */

namespace EasySwoole\WeChat\Payment;

class ApiUrl
{
    // 公共支付接口

    const PAY_UNIFIED_ORDER = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

    /**
     * 查询订单
     */
    const PAY_ORDER_QUERY = 'https://api.mch.weixin.qq.com/pay/orderquery';

    /**
     * 关闭订单 (码支付无此接口)
     */
    const PAY_CLOSE_ORDER = 'https://api.mch.weixin.qq.com/pay/closeorder';

    /**
     * 申请退款
     */
    const PAY_REFUND = 'https://api.mch.weixin.qq.com/secapi/pay/refund';

    /**
     * 查询退款
     */
    const PAY_REFUND_QUERY = 'https://api.mch.weixin.qq.com/pay/refundquery';

    /**
     * 下载对账单
     */
    const PAY_DOWNLOAD_BILL = 'https://api.mch.weixin.qq.com/pay/downloadbill';

    /**
     * 下载资金账单
     */
    const PAY_DOWNLOAD_FUND_FLOW = 'https://api.mch.weixin.qq.com/pay/downloadfundflow';

    /**
     * 交易保障主动上报
     */
    const PAYITIL_REPORT = 'https://api.mch.weixin.qq.com/payitil/report';

    /**
     * 码支付上报路径
     */
    const PAY_MICRO_REPORT = 'https://api.mch.weixin.qq.com/pay/batchreport/micropay/total';

    /**
     * 统一下单支付上报路径
     */
    const PAY_UNIFIED_REPORT = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

    /**
     * 拉取订单评价数据
     */
    const PAY_BATCH_QUERY_COMMENT = 'https://api.mch.weixin.qq.com/billcommentsp/batchquerycomment';

    /**
     * 提交付款码支付(码支付独有)
     */
    const PAY_MICRO_PAY = 'https://api.mch.weixin.qq.com/pay/micropay';

    /**
     * 撤销支付订单(码支付独有)
     */
    const PAY_REVERSE = 'https://api.mch.weixin.qq.com/secapi/pay/reverse';

    /**
     * 授权码查询OPENID(码支付独有)
     */
    const PAY_AUTH_CODE_TO_OPENID = 'https://api.mch.weixin.qq.com/tools/authcodetoopenid';

    /**
     * 原生支付二维码转短链(Native独有)
     */
    const PAY_SHORT_URL = 'https://api.mch.weixin.qq.com/tools/shorturl';
}