<?php

namespace EasySwoole\WeChat\MiniProgram\ContentSecurity;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\ContentSecurity
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/sec-check/security.imgSecCheck.html
 * desc 内容安全相关接口
 *
 */
class Client extends BaseClient
{
    /**
     * imgSecurityCheck
     * 校验一张图片是否含有违法违规内容
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/sec-check/security.imgSecCheck.html
     *
     * @param string $path
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function checkImg(string $path)
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf("File does not exist, or the file is unreadable: '%s'", $path));
        }

        $client = $this->getClient()
            ->setMethod('POST')
            ->addFile($path, 'media');

        $response = $client->send($this->buildUrl(
            '/wxa/img_sec_check',
            [
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            ]
        ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * mediaCheckAsync
     * 异步校验图片/音频是否含有违法违规内容。
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/sec-check/security.mediaCheckAsync.html
     *
     * @param string $mediaUrl
     * @param int $mediaType
     * @param string $openId
     * @param int $scene
     * @param int $version
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function checkMediaAsync(string $mediaUrl, int $mediaType, string $openId, int $scene, int $version = 2)
    {
        if (!in_array($mediaType, [1, 2], true)) {
            throw new InvalidArgumentException("The value of parameter mediaType is illegal!");
        }

        if (!in_array($scene, [1, 2, 3, 4], true)) {
            throw new InvalidArgumentException("The value of parameter scene is illegal!");
        }

        $params = [
            'media_url' => $mediaUrl,
            'media_type' => $mediaType,
            'version' => $version,
            'openid' => $openId,
            'scene' => $scene
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/media_check_async',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * msgSecurityCheck
     * 检查一段文本是否含有违法违规内容。
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/sec-check/security.msgSecCheck.html
     *
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function checkMsg(array $params)
    {
        if (!isset($params['scene']) || !in_array($params['scene'], [1, 2, 3, 4], true)) {
            throw new InvalidArgumentException("The value of parameter scene is illegal!");
        }

        $params['version'] = 2;

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/msg_sec_check',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
