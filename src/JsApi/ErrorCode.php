<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 10:19 PM
 */

namespace EasySwoole\WeChat\JsApi;


class ErrorCode
{
    /*
     * map to https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
     */

    /**
     * 正常
     */
    const OK = 0;

    /**
     * redirect_uri 域名与后台配置不一致
     * 回调授权域名不匹配
     */
    const REDIRECT_URI_ERROR = 10003;

    /**
     * 公众号被封禁
     */
    const OFFICIAL_ACCOUNT_BANNED = 10004;

    /**
     * 公众号未拥有 scope(应用授权作用域) 权限
     */
    const OFFICIAL_ACCOUNT_NOT_SCOPE_PERMISSION = 10005;

    /**
     * 必须关注测试账号
     */
    const MUST_SUBSCRIBE_TEST_ACCOUNT = 10006;

    /**
     * 操作频繁
     */
    const FREQUENT_OPERATION = 10009;

    /**
     * scope(应用授权作用域) 不能为空
     */
    const SCOPE_NOT_EMPTY = 10010;

    /**
     * 回调授权url 不能为空
     */
    const REDIRECT_URI_NOT_EMPTY = 10011;

    /**
     * appid 不能为空
     */
    const APP_ID_NOT_EMPTY = 10012;

    /**
     * state(重定自定义参数) 不能为空
     */
    const STATE_NOT_EMPTY = 10013;

    /**
     * 公众号未开放第三方平台授权
     */
    const OFFICIAL_ACCOUNT_NOT_OPEN_PERMISSION = 10015;

    /**
     * 不支持开放平台 Appid 请使用公众号 Appid
     */
    const APP_ID_ERROR = 10016;

}