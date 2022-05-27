<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\QrCodeJump;

use EasySwoole\WeChat\Kernel\Psr\Stream;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 获取已设置的二维码规则
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/qrcode/qrcodejumpget.html
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody(new Stream(json_encode(new \stdClass())))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/qrcodejumpget",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 获取校验文件名称及内容
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/qrcode/qrcodejumpdownload.html
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function download()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody(new Stream(json_encode(new \stdClass())))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/qrcodejumpdownload",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 增加或修改二维码规则
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/qrcode/qrcodejumpadd.html
     *
     * @param array $jumpData 二维码规则
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add(array $jumpData)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($jumpData))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/qrcodejumpadd",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 发布已设置的二维码规则
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/qrcode/qrcodejumppublish.html
     *
     * @param string $prefix
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function publish(string $prefix)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['prefix' => $prefix]))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/qrcodejumppublish",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 删除已设置的二维码规则
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/qrcode/qrcodejumpdelete.html
     *
     * @param string $prefix
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(string $prefix)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['prefix' => $prefix]))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/qrcodejumpdelete",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 将二维码长链接转成短链接
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/qrcode/shorturl.html
     *
     * @param string $longUrl
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getShorturl(string $longUrl)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'action' => 'long2short',
                'long_url' => $longUrl
            ]))
            ->send($this->buildUrl(
                "/cgi-bin/shorturl",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 获取 unlimited 小程序码
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.getUnlimited.html
     *
     * @param array $param
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUnlimitWxCode(array $param)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                "/wxa/getwxacodeunlimit",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 获取小程序码
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.get.html
     *
     * @param array $param
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWxCode(array $param)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                "/wxa/getwxacode",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 普通链接二维码与小程序码 - 获取小程序二维码
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.createQRCode.html
     *
     * @param string $path
     * @param int $width
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWxQrCode(string $path, int $width = 430)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'path' => $path,
                'width' => $width
            ]))
            ->send($this->buildUrl(
                "/cgi-bin/wxaapp/createwxaqrcode",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        return $this->checkResponse($response);
    }
}
