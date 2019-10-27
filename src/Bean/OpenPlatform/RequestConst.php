<?php


namespace EasySwoole\WeChat\Bean\OpenPlatform;


class RequestConst
{
    /** @var string 授权成功事件 */
    const EVENT_AUTHORIZED = 'authorized';
    /** @var string 授权更新事件 */
    const EVENT_UPDATE_AUTHORIZED = 'updateauthorized';
    /** @var string 授权取消事件 */
    const EVENT_UNAUTHORIZED = 'unauthorized';
    /** @var string VerifyTicket 事件 */
    const EVENT_VERIFY_TICKET = 'component_verify_ticket';
}