<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class MediaClient
 * @package EasySwoole\WeChat\MiniProgram\Mall
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class MediaClient extends BaseClient
{
    /**
     * 更新或导入媒体信息.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/goods/importmedia.part.html
     *
     * @param $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/6 23:42
     * @author: XueSi
     * @email: <1592328848@qq.com>
     */
    public function import($params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/importmedia',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}