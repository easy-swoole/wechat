<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Material;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 这个接口位置不对 属于公众号的接口
     * 公众号 - 素材管理 - 获取永久素材
     *
     * 获取永久素材
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Asset_Management/Getting_Permanent_Assets.html
     *
     * @param string $mediaId
     * @return StreamResponse
     * @throws HttpException
     */
    public function get(string $mediaId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['media_id' => $mediaId]))
            ->send($this->buildUrl(
                "/cgi-bin/material/get_material",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }
}
