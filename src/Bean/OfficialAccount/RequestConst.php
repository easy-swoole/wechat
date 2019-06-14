<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 17:14
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


class RequestConst
{
    /*
    * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140453
    */
    const DEFAULT_ON_MESSAGE = '__DEFAULT_ON_MESSAGE__';
    const DEFAULT_ON_EVENT = '__DEFAULT_ON_EVENT__';

    const MSG_TYPE_TEXT = 'text';
    const MSG_TYPE_EVENT = 'event';
    const MSG_TYPE_IMAGE = 'image';
    const MSG_TYPE_MUSIC = 'music';
    const MSG_TYPE_VOICE = 'voice';
    const MSG_TYPE_VIDEO = 'video';
    const MSG_TYPE_SHORT_VIDEO = 'shortvideo';
    const MSG_TYPE_LOCATION = 'location';
    const MSG_TYPE_LINK = 'link';
    const MSG_TYPE_NEWS = 'news';//仅仅出现在被动回复中



    /*
     * 事件大小写不同，主要是微信自己本身事件大小写就不一样，不规范
     */
    const EVENT_SUBSCRIBE = 'subscribe';
    const EVENT_UNSUBSCRIBE = 'unsubscribe';
    const EVENT_SCAN = 'SCAN';
    const EVENT_LOCATION = 'LOCATION';
    const EVENT_CLICK = 'CLICK';
    const EVENT_VIEW = 'VIEW';
    const EVENT_TEMPLATE_SEND_JOB_FINISH = 'TEMPLATESENDJOBFINISH';
}