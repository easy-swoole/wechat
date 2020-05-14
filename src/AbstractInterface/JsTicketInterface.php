<?php


namespace EasySwoole\WeChat\AbstractInterface;


interface JsTicketInterface
{
    function getTicket($refreshTimes = 1): ?string;
    function refreshTicket(): ?string;
}