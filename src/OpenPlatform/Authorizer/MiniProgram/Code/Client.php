<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Code;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 代码管理 - 上传代码
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/commit.html
     *
     * @param int $templateId
     * @param string $extJson
     * @param string $version
     * @param string $description
     * @return mixed
     * @throws HttpException
     */
    public function commit(int $templateId, string $extJson, string $version, string $description)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'template_id' => $templateId,
                'ext_json' => $extJson,
                'user_version' => $version,
                'user_desc' => $description,
            ]))->send($this->buildUrl(
                "/wxa/commit",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 获取已上传的代码的页面列表
     * doc link：https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/get_page.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getPage()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/get_page",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 获取体验版二维码
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/get_qrcode.html
     *
     * @param string|null $path
     * @return bool|StreamResponse
     * @throws HttpException
     */
    public function getQrCode(string $path = null)
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/get_qrcode",
                [
                    'path' => $path,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 提交审核
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/submit_audit.html
     *
     * @param array $data
     * @param string|null $feedbackInfo
     * @param string|null $feedbackStuff
     * @return array
     * @throws HttpException
     */
    public function submitAudit(array $data, string $feedbackInfo = null, string $feedbackStuff = null)
    {
        if (isset($data['item_list'])) {
            $params = $data;
        } else {
            $params = [
                'item_list' => $data,
                'feedback_info' => $feedbackInfo,
                'feedback_stuff' => $feedbackStuff,
            ];
        }

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/submit_audit",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 查询指定发布审核单的审核状态
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/get_auditstatus.html
     *
     * @param int $auditId
     * @return mixed
     * @throws HttpException
     */
    public function getAuditStatus(int $auditId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['auditid' => $auditId]))
            ->send($this->buildUrl(
                "/wxa/get_auditstatus",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 查询最新一次提交的审核状态
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/get_latest_auditstatus.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getLatestAuditStatus()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/get_latest_auditstatus",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 小程序审核撤回
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/undocodeaudit.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function withdrawAudit()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/undocodeaudit",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 发布已通过审核的小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/release.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function release()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([]))
            ->send($this->buildUrl(
                "/wxa/release",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 版本回退
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/revertcoderelease.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function rollbackRelease(int $appVersion = null)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
        ];

        if (!is_null($appVersion)) {
            $query['app_version'] = $appVersion;
        }

        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/revertcoderelease",
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 获取可回退的小程序版本
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/get_history_version.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getHistoryVersion()
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'get_history_version'
        ];

        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/revertcoderelease",
                $query
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 分阶段发布
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/grayrelease.html
     *
     * @param int $grayPercentage
     * @return mixed
     * @throws HttpException
     */
    public function grayRelease(int $grayPercentage)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['gray_percentage' => $grayPercentage]))
            ->send($this->buildUrl(
                "/wxa/grayrelease",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 查询当前分阶段发布详情
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/getgrayreleaseplan.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getGrayRelease()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/getgrayreleaseplan",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 取消分阶段发布
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/revertgrayrelease.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function revertGrayRelease()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/revertgrayrelease",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 修改小程序服务状态
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/change_visitstatus.html
     *
     * @param string $action
     * @return mixed
     * @throws HttpException
     */
    public function changeVisitStatus(string $action)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['action' => $action]))
            ->send($this->buildUrl(
                "/wxa/change_visitstatus",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 查询当前设置的最低基础库版本及各版本用户占比
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/getweappsupportversion.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function getSupportVersion()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/getweappsupportversion",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 设置最低基础库版本
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/setweappsupportversion.html
     *
     * @param string $version
     * @return mixed
     * @throws HttpException
     */
    public function setSupportVersion(string $version)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['version' => $version]))
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/setweappsupportversion",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response, $data);
    }

    /**
     * 代小程序实现业务 - 代码管理 - 查询服务商的当月提审限额（quota）和加急次数
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/query_quota.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function queryQuota()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/queryquota",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 代码管理 - 加急审核申请
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/code/speedup_audit.html
     *
     * @param int $auditId 审核单ID
     * @return mixed
     * @throws HttpException
     */
    public function speedupAudit(int $auditId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['auditid' => $auditId]))
            ->send($this->buildUrl(
                "/wxa/speedupaudit",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
