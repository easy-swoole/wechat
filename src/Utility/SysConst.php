<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:33 PM
 */

namespace EasySwoole\WeChat\Utility;


class SysConst
{
    /*
     * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140453
     */
    const OFFICIAL_ACCOUNT_DEFAULT_ON_MESSAGE = '__DEFAULT_ON_MESSAGE__';
    const OFFICIAL_ACCOUNT_DEFAULT_ON_EVENT = '__DEFAULT_ON_EVENT__';

    const OFFICIAL_ACCOUNT_MSG_TYPE_TEXT = 'text';
    const OFFICIAL_ACCOUNT_MSG_TYPE_EVENT = 'event';
    const OFFICIAL_ACCOUNT_MSG_TYPE_IMAGE = 'image';
    const OFFICIAL_ACCOUNT_MSG_TYPE_VOICE = 'voice';
    const OFFICIAL_ACCOUNT_MSG_TYPE_VIDEO = 'video';
    const OFFICIAL_ACCOUNT_MSG_TYPE_SHORT_VIDEO = 'shortvideo';
    const OFFICIAL_ACCOUNT_MSG_TYPE_LOCATION = 'location';
    const OFFICIAL_ACCOUNT_MSG_TYPE_LINK = 'link';



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