<?php


namespace EasySwoole\WeChat\BasicService\QrCode;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @package EasySwoole\WeChat\BasicService\QrCode
 */
class Client extends BaseClient
{
    public const DAY = 86400;
    public const SCENE_MAX_VALUE = 100000;
    public const SCENE_QR_CARD = 'QR_CARD';
    public const SCENE_QR_TEMPORARY = 'QR_SCENE';
    public const SCENE_QR_TEMPORARY_STR = 'QR_STR_SCENE';
    public const SCENE_QR_FOREVER = 'QR_LIMIT_SCENE';
    public const SCENE_QR_FOREVER_STR = 'QR_LIMIT_STR_SCENE';

    /**
     * Create forever QR code.
     */
    public function forever($sceneValue)
    {
        if (is_int($sceneValue) && $sceneValue > 0 && $sceneValue < self::SCENE_MAX_VALUE) {
            $type = self::SCENE_QR_FOREVER;
            $sceneKey = 'scene_id';
        } else {
            $type = self::SCENE_QR_FOREVER_STR;
            $sceneKey = 'scene_str';
        }
        $scene = [$sceneKey => $sceneValue];

        return $this->create($type, $scene, false);
    }

    /**
     * Create temporary QR code.
     */
    public function temporary($sceneValue, $expireSeconds = null)
    {
        if (is_int($sceneValue) && $sceneValue > 0) {
            $type = self::SCENE_QR_TEMPORARY;
            $sceneKey = 'scene_id';
        } else {
            $type = self::SCENE_QR_TEMPORARY_STR;
            $sceneKey = 'scene_str';
        }
        $scene = [$sceneKey => $sceneValue];

        return $this->create($type, $scene, true, $expireSeconds);
    }

    /**
     * Return url for ticket.
     * https://developers.weixin.qq.com/doc/offiaccount/Account_Management/Generating_a_Parametric_QR_Code.html
     *
     * @param string $ticket
     *
     * @return string
     */
    public function url($ticket)
    {
        return sprintf('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=%s', urlencode($ticket));
    }

    /**
     * Create a QrCode.
     */
    protected function create($actionName, $actionInfo, $temporary = true, $expireSeconds = null)
    {
        null !== $expireSeconds || $expireSeconds = 7 * self::DAY;

        $params = [
            'action_name' => $actionName,
            'action_info' => ['scene' => $actionInfo],
        ];

        if ($temporary) {
            $params['expire_seconds'] = min($expireSeconds, 30 * self::DAY);
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl('/cgi-bin/qrcode/create', [
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
            ]));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
