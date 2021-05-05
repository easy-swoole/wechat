<?php

namespace EasySwoole\WeChat\MiniProgram\OpenData;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client.
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\OpenData
 *
 * 微信小游戏-开放数据接口
 * doc link: https://developers.weixin.qq.com/minigame/dev/api-backend/open-api/data/storage.setUserStorage.html#HTTPS%20%E8%B0%83%E7%94%A8
 *
 */
class Client extends BaseClient
{
    /**
     * storage.removeUserStorage 删除已经上报到微信的key-value数据
     * removeUserStorage.
     * doc link: https://developers.weixin.qq.com/minigame/dev/api-backend/open-api/data/storage.removeUserStorage.html
     *
     * @param string $openid
     * @param string $sessionKey
     * @param array  $key
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function removeUserStorage(string $openid, string $sessionKey, array $key)
    {
        $data = ['key' => $key];
        $query = [
            'openid' => $openid,
            'sig_method' => 'hmac_sha256',
            'signature' => hash_hmac('sha256', json_encode($data), $sessionKey),
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/wxa/remove_user_storage',
                $query)
            );
        return $this->checkResponse($response);
    }

    /**
     * storage.setUserStorage 上报用户数据后台接口
     * setUserStorage.
     * doc link: https://developers.weixin.qq.com/minigame/dev/api-backend/open-api/data/storage.setUserStorage.html
     *
     * @param string $openid
     * @param string $sessionKey
     * @param array  $kvList
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setUserStorage(string $openid, string $sessionKey, array $kvList)
    {
        $kvList = $this->formatKVLists($kvList);

        $data = ['kv_list' => $kvList];
        $query = [
            'openid' => $openid,
            'sig_method' => 'hmac_sha256',
            'signature' => hash_hmac('sha256', json_encode($data), $sessionKey),
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/wxa/set_user_storage',
                $query)
            );

        return $this->checkResponse($response);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function formatKVLists(array $params)
    {
        $formatted = [];

        foreach ($params as $name => $value) {
            $formatted[] = [
                'key' => $name,
                'value' => strval($value),
            ];
        }

        return $formatted;
    }
}
