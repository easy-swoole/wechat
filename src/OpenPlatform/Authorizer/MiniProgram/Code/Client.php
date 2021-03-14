<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Code;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
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

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * @param string|null $path
     * @return StreamResponse
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

        $this->checkResponse($response);
    }

    /**
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
     * @return mixed
     * @throws HttpException
     */
    public function release()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->send($this->buildUrl(
                "/wxa/release",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function rollbackRelease()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/revertcoderelease",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 分阶段发布
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 取消分阶段发布
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 查询当前分阶段发布详情
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
     * 查询当前设置的最低基础库版本及各版本用户占比
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
     * 设置最低基础库版本
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

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 查询服务商的当月提审限额（quota）和加急次数
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
     * 加急审核申请
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

        $this->checkResponse($response, $data);

        return $data;
    }
}
