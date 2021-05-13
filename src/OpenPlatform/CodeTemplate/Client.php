<?php

namespace EasySwoole\WeChat\OpenPlatform\CodeTemplate;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\OpenPlatform\CodeTemplate
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取草稿箱内的所有临时代码草稿.
     * 代小程序实现业务 - 代码模板库设置 - 获取代码草稿列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code_template/gettemplatedraftlist.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getDrafts()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/gettemplatedraftlist",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * 将草稿箱的草稿选为小程序代码模版.
     * 代小程序实现业务 - 代码模板库设置 - 将草稿添加到代码模板库
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code_template/addtotemplate.html
     *
     * @param int $draftId
     * @return mixed
     * @throws HttpException
     */
    public function createFromDraft(int $draftId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'draft_id' => $draftId,
            ]))->send($this->buildUrl(
                "/wxa/addtotemplate",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取代码模版库中的所有小程序代码模版.
     * 代小程序实现业务 - 代码模板库设置 - 获取代码模板列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code_template/gettemplatelist.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/gettemplatelist",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * 删除指定小程序代码模版.
     * 获取代码模版库中的所有小程序代码模版.
     * 代小程序实现业务 - 代码模板库设置 - 删除指定代码模板
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code_template/deletetemplate.html
     *
     * @param $templateId
     * @return mixed
     * @throws HttpException
     */
    public function delete($templateId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'template_id' => $templateId,
            ]))->send($this->buildUrl(
                "/wxa/deletetemplate",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
