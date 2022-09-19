<?php
declare(strict_types=1);

/**
 ***********作者信息**********
 * Author: ysongyang
 * Email: 49271743@qq.com
 * Desc: 半屏小程序管理
 * Date: 2022/9/19 13:11
 *****************************
 */

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Embedded;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{

    /**
     * 代商家管理小程序 - 半屏小程序管理 - 添加半屏小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/embedded-management/addEmbedded.html
     * @param string $appid 添加的半屏小程序 appid
     * @param string $apply_reason 申请理由，不超过 30 个字
     * @return mixed
     * @throws HttpException
     */
    public function addEmbedded(string $appid, string $apply_reason = "")
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['appid' => $appid, 'apply_reason' => $apply_reason]))
            ->send($this->buildUrl(
                "/wxaapi/wxaembedded/add_embedded",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }


    /**
     * 代商家管理小程序 - 半屏小程序管理 - 删除半屏小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/embedded-management/deleteEmbedded.html
     * @param string $appid 添加的半屏小程序 appid
     * @return mixed
     * @throws HttpException
     */
    public function deleteEmbedded(string $appid)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['appid' => $appid]))
            ->send($this->buildUrl(
                "/wxaapi/wxaembedded/del_embedded",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代商家管理小程序 - 半屏小程序管理 - 设置授权方式
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/embedded-management/setAuthorizedEmbedded.html
     * @param int $flag 半屏小程序授权方式。0表示需要管理员验证；1表示自动通过；2表示自动拒绝。
     * @return mixed
     * @throws HttpException
     */
    public function setAuthorizedEmbedded(int $flag)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['flag' => $flag]))
            ->send($this->buildUrl(
                "/wxaapi/wxaembedded/set_authorize",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代商家管理小程序 - 半屏小程序管理 - 取消授权小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/embedded-management/deleteAuthorizedEmbedded.html
     * @param int $flag 半屏小程序授权方式。0表示需要管理员验证；1表示自动通过；2表示自动拒绝。
     * @return mixed
     * @throws HttpException
     */
    public function deleteAuthorizedEmbedded(int $flag)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['flag' => $flag]))
            ->send($this->buildUrl(
                "/wxaapi/wxaembedded/del_authorize",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 获取半屏小程序调用列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/embedded-management/getEmbeddedList.html
     *
     * @param int $start
     * @param int $num
     * @return mixed
     * @throws HttpException
     */
    public function getEmbeddedList(int $start = 0, int $num = 10)
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxaapi/wxaembedded/get_list",
                [
                    'start' => $start,
                    'num' => $num,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 获取半屏小程序授权列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/embedded-management/getOwnList.html
     *
     * @param int $start
     * @param int $num
     * @return mixed
     * @throws HttpException
     */
    public function getOwnList(int $start = 0, int $num = 10)
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxaapi/wxaembedded/get_own_list",
                [
                    'start' => $start,
                    'num' => $num,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }
}