<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Setting;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 类目管理 - 获取可以设置的所有类目
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/getallcategories.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getAllCategories()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/getallcategories",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 类目管理 - 获取账号已经设置的所有类目
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/getcategory.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getCategories()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/getcategory",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 类目管理 - 获取不同主体类型的类目
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/getcategorybytype.html
     */
    public function getCategoriesByType(int $verifyType = 0)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['verify_type' => $verifyType]))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/getcategoriesbytype",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 类目管理 - 添加类目
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/addcategory.html
     *
     * @param array $categories
     * @return mixed
     * @throws HttpException
     */
    public function addCategories(array $categories)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['categories' => $categories]))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/addcategory",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 类目管理 - 删除类目
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/deletecategory.html
     *
     * @param int $firstId 一级类目ID
     * @param int $secondId 二级类目ID
     * @return mixed
     * @throws HttpException
     */
    public function deleteCategories(int $firstId, int $secondId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['first' => $firstId, 'second' => $secondId]))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/deletecategory",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response, $data);
    }

    /**
     * 代小程序实现业务 - 类目管理 - 修改类目资质信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/modifycategory.html
     *
     * @param array $category
     * @return mixed
     * @throws HttpException
     */
    public function updateCategory(array $category)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($category))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/modifycategory",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 类目管理 - 获取审核时可填写的类目信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/category/get_category.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getCategory()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/get_category",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 小程序名称设置及改名
     * 代小程序实现业务 - 基础信息设置 - 设置名称
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/setnickname.html
     *
     * @param string $nickname 昵称
     * @param string $idCardMediaId 身份证照片素材ID
     * @param string $licenseMediaId 组织机构代码证或营业执照素材ID
     * @param array $otherStuffs 其他证明材料素材ID
     * @return mixed
     * @throws HttpException
     */
    public function setNickname(
        string $nickname,
        string $idCardMediaId = '',
        string $licenseMediaId = '',
        array $otherStuffs = []
    )
    {
        $params = [
            'nick_name' => $nickname,
            'id_card' => $idCardMediaId,
            'license' => $licenseMediaId,
        ];

        for ($i = count($otherStuffs) - 1; $i >= 0; --$i) {
            $params['naming_other_stuff_' . ($i + 1)] = $otherStuffs[$i];
        }

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/setnickname",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 基础信息设置 - 微信认证名称检测
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/wxverify_checknickname.html
     *
     * @param string $nickname 名称（昵称）
     * @return mixed
     * @throws HttpException
     */
    public function isAvailableNickname(string $nickname)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['nick_name' => $nickname]))
            ->send($this->buildUrl(
                "/cgi-bin/wxverify/checkwxverifynickname",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 小程序改名审核状态查询
     * 代小程序实现业务 - 基础信息设置 - 查询改名审核状态
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/api_wxa_querynickname.html
     *
     * @param string $auditId 审核单id
     * @return mixed
     * @throws HttpException
     */
    public function getNicknameAuditStatus(string $auditId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['audit_id' => $auditId]))
            ->send($this->buildUrl(
                "/wxa/api_wxa_querynickname",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 查询小程序是否可被搜索
     * 代小程序实现业务 - 基础信息设置 - 查询隐私设置
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/getwxasearchstatus.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getSearchStatus()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/getwxasearchstatus",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 设置小程序可被搜素
     * 代小程序实现业务 - 基础信息设置 - 修改隐私设置
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/changewxasearchstatus.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function setSearchable()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['status' => 0]))
            ->send($this->buildUrl(
                "/wxa/changewxasearchstatus",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 设置小程序不可被搜素
     * 代小程序实现业务 - 基础信息设置 - 修改隐私设置
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/changewxasearchstatus.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function setUnsearchable()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['status' => 1]))
            ->send($this->buildUrl(
                "/wxa/changewxasearchstatus",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 扫码关注组件 - 获取展示的公众号信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/subscribe_component/getshowwxaitem.html
     *
     * 获取展示的公众号信息
     * @return mixed
     * @throws HttpException
     */
    public function getDisplayedOfficialAccount()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/getshowwxaitem",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 扫码关注组件 - 获取可以用来设置的公众号列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/subscribe_component/getwxamplinkforshow.html
     *
     * 获取可以用来设置的公众号列表
     * @param int $page
     * @param int $num
     * @return mixed
     * @throws HttpException
     */
    public function getDisplayableOfficialAccounts(int $page = 0, int $num = 20)
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/getwxamplinkforshow",
                [
                    'page' => $page,
                    'num' => $num,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 扫码关注组件 - 设置展示的公众号信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/subscribe_component/updateshowwxaitem.html
     *
     * 设置展示的公众号
     * @param $appid
     * @return mixed
     * @throws HttpException
     */
    public function setDisplayedOfficialAccount(string $appid = null)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $appid ?: null,
                'wxa_subscribe_biz_flag' => $appid ? 1 : 0,
            ]))->send($this->buildUrl(
                "/wxa/updateshowwxaitem",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
