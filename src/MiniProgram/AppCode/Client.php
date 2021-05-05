<?php


namespace EasySwoole\WeChat\MiniProgram\AppCode;


use EasySwoole\WeChat\Kernel\Contracts\StreamResponseInterface;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取小程序二维码
     * wxacode.createQRCode
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.createQRCode.html
     *
     * @param string $path
     * @param int|null $width
     * @return StreamResponseInterface
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getQrCode(string $path, int $width = null)
    {
        return $this->getStream('/cgi-bin/wxaapp/createwxaqrcode', compact('path', 'width'));
    }

    /**
     * 获取小程序码
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.get.html
     *
     * @param string $path
     * @param array $optional
     * @return StreamResponseInterface
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $path, array $optional = [])
    {
        $params = array_merge([
            'path' => $path,
        ], $optional);

        return $this->getStream('/wxa/getwxacode', $params);
    }

    /**
     * 获取小程序码
     * wxacode.getUnlimited
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.getUnlimited.html
     *
     * @param string $scene
     * @param array $optional
     * @return StreamResponseInterface
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUnLimit(string $scene, array $optional = [])
    {
        $params = array_merge([
            'scene' => $scene,
        ], $optional);

        return $this->getStream('/wxa/getwxacodeunlimit', $params);
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return bool|StreamResponse
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    protected function getStream(string $endpoint, array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                $endpoint,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        return $this->checkResponse($response);
    }
}
