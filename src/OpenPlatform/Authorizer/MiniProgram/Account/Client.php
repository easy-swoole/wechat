<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Account;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\Account\Client as BaseClient;
use EasySwoole\WeChat\OpenPlatform\Application;
use function strval;

class Client extends BaseClient
{
    protected $component;

    /**
     * Client constructor.
     * @param ServiceContainer $app
     * @param Application $component
     */
    public function __construct(ServiceContainer $app, Application $component)
    {
        parent::__construct($app);

        $this->component = $component;
    }

    /**
     * 代小程序实现业务 - 基本信息设置 - 获取基本信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/Mini_Program_Information_Settings.html
     * @return mixed
     * @throws HttpException
     */
    public function getBasicInfo()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/cgi-bin/account/getaccountbasicinfo",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * 代小程序实现业务 - 基本信息设置 - 修改头像
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/modifyheadimage.html
     *
     * @param string $mediaId 头像素材mediaId
     * @param string $left 剪裁框左上角x坐标（取值范围：[0, 1]）
     * @param string $top 剪裁框左上角y坐标（取值范围：[0, 1]）
     * @param string $right 剪裁框右下角x坐标（取值范围：[0, 1]）
     * @param string $bottom 剪裁框右下角y坐标（取值范围：[0, 1]）
     *
     * @return mixed
     * @throws HttpException
     */
    public function updateAvatar(
        string $mediaId,
        $left = '0.0',
        $top = '0.0',
        $right = '1.0',
        $bottom = '1.0'
    )
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'head_img_media_id' => $mediaId,
                'x1' => strval($left),
                'y1' => strval($top),
                'x2' => strval($right),
                'y2' => strval($bottom),
            ]))->send($this->buildUrl(
                "/cgi-bin/account/modifyheadimage",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 基本信息设置 - 修改简介
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/modifysignature.html
     *
     * @param string $signature 功能介绍（简介）
     * @return mixed
     * @throws HttpException
     */
    public function updateSignature(string $signature)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['signature' => $signature]))
            ->send($this->buildUrl(
                "/cgi-bin/account/modifysignature",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
