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
    const DEFAULT_ON_EVENT   = '__DEFAULT_ON_EVENT__';

    const MSG_TYPE_TEXT        = 'text';
    const MSG_TYPE_EVENT       = 'event';
    const MSG_TYPE_IMAGE       = 'image';
    const MSG_TYPE_MUSIC       = 'music';
    const MSG_TYPE_VOICE       = 'voice';
    const MSG_TYPE_VIDEO       = 'video';
    const MSG_TYPE_SHORT_VIDEO = 'shortvideo';
    const MSG_TYPE_LOCATION    = 'location';
    const MSG_TYPE_LINK        = 'link';
    const MSG_TYPE_NEWS        = 'news';

    /**
     * 客服发送消息中出现
     */
    const MSG_TYPE_MPNEWS          = 'mpnews';
    const MSG_TYPE_MSGMENU         = 'msgmenu';
    const MSG_TYPE_WXCARD          = 'wxcard';
    const MSG_TYPE_MINIPROGRAMPAGE = 'miniprogrampage';

    /**
     * 群发消息中出现
     */
    const MSG_TYPE_MPVIDEO = 'mpvideo';


    /*
     * 事件大小写不同，主要是微信自己本身事件大小写就不一样，不规范
     */
    // 用户关注事件
    const EVENT_SUBSCRIBE = 'subscribe';
    // 用户取消关注事件
    const EVENT_UNSUBSCRIBE = 'unsubscribe';
    // 用户已关注事件
    const EVENT_SCAN = 'SCAN';
    // 上报地理位置事件
    const EVENT_LOCATION = 'LOCATION';
    // 点击自定义菜单拉取消息事件
    const EVENT_CLICK = 'CLICK';
    // 点击自定义菜单跳转事件
    const EVENT_VIEW = 'VIEW';
    // 发送模板消息通知事件
    const EVENT_TEMPLATE_SEND_JOB_FINISH = 'TEMPLATESENDJOBFINISH';
    // 群发结果事件
    const EVENT_MASS_SEND_JOB_FINISH           = 'MASSSENDJOBFINISH';
    //扫码推事件的事件推送
    const EVENT_SCANCODE_PUSH = 'scancode_push';
    //扫码推事件且弹出“消息接收中”提示框的事件推送
    const EVENT_SCANCODE_WAITMSG = 'scancode_waitmsg';
    //弹出系统拍照发图的事件推送
    const EVENT_PIC_SYSPHOTO = 'pic_sysphoto';
    //弹出拍照或者相册发图的事件推送
    const EVENT_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';
    //弹出微信相册发图器的事件推送
    const EVENT_PIC_WEIXIN = 'pic_weixin';
    //弹出地理位置选择器的事件推送
    const EVENT_LOCATION_SELECT = 'location_select';
    //点击菜单跳转小程序的事件推送
    const EVENT_VIEW_MINIPROGRAM = 'view_miniprogram';

}