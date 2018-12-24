<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:05 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;


class SysConst
{
    const OFFICIAL_ACCOUNT_DEFAULT_ON_MESSAGE = '__DEFAULT_ON_MESSAGE__';
    const OFFICIAL_ACCOUNT_DEFAULT_ON_EVENT = '__DEFAULT_ON_EVENT__';

    const OFFICIAL_ACCOUNT_MSG_TYPE_TEXT = 'text';
    const OFFICIAL_ACCOUNT_MSG_TYPE_EVENT = 'event';

    /*
     * 事件大小写不同，主要是微信自己本身事件大小写就不一样，不规范
     */
    const OFFICIAL_ACCOUNT_EVENT_SUBSCRIBE = 'subscribe';
    const OFFICIAL_ACCOUNT_EVENT_UNSUBSCRIBE = 'unsubscribe';
    const OFFICIAL_ACCOUNT_EVENT_SCAN = 'SCAN';
    const OFFICIAL_ACCOUNT_EVENT_LOCATION = 'LOCATION';
    const OFFICIAL_ACCOUNT_EVENT_CLICK = 'CLICK';
    const OFFICIAL_ACCOUNT_EVENT_VIEW = 'VIEW';
}