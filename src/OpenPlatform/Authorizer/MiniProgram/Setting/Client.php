<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Setting;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取账号可以设置的所有类目
     * @return mixed
     * @throws HttpException
     */
    public function getAllCategories()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/getallcategories",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 添加类目
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 删除类目
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 获取账号已经设置的所有类目
     * @return mixed
     * @throws HttpException
     */
    public function getCategories()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/getcategory",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 修改类目
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 小程序名称设置及改名
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
     * 小程序改名审核状态查询
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
     * 微信认证名称检测.
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
     * 查询小程序是否可被搜索
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 设置小程序不可被搜素
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
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
     * 设置展示的公众号
     * @param $appid
     * @return mixed
     * @throws HttpException
     */
    public function setDisplayedOfficialAccount($appid)
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 获取可以用来设置的公众号列表
     * @param int $page
     * @param int $num
     * @return mixed
     * @throws HttpException
     */
    public function getDisplayableOfficialAccounts(int $page, int $num)
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
}
