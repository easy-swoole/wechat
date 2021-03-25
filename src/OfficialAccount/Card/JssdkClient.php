<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\BasicService\Jssdk\Client as Jssdk;
use EasySwoole\WeChat\Kernel\Utility\Random;

class JssdkClient extends Jssdk
{
    /**
     * @param bool $autoRefresh
     * @return string
     */
    public function getTicket(bool $autoRefresh = true): string
    {
        return parent::getTicket($autoRefresh);
    }

    /**
     * 微信卡劵 jsapi 卡劵发放
     * @param array $cards
     * @return false|string
     */
    public function assign(array $cards)
    {
        return json_encode(array_map(function ($card) {
            return $this->attachExtension($card['card_id'], $card);
        }, $cards));
    }

    /**
     * @param $cardId
     * @param array $extension
     * @return array
     */
    public function attachExtension($cardId, array $extension = [])
    {
        $timestamp = time();
        $nonce = Random::character(6);
        $ticket = $this->getTicket();

        $ext = array_merge(['timestamp' => $timestamp, 'nonce_str' => $nonce], array_intersect_key($extension, array_flip(['code', 'openid', 'outer_id', 'balance', 'fixed_begintimestamp', 'outer_str'])));

        $ext['signature'] = $this->dictionaryOrderSignature($ticket, $timestamp, $cardId, $ext['code'] ?? '', $ext['openid'] ?? '', $nonce);

        return [
            'cardId' => $cardId,
            'cardExt' => json_encode($ext),
        ];
    }
}