<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/7
 * Time: 21:50
 */

namespace EasySwoole\WeChat\MiniProgram\RiskControl;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\RiskControl
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * desc 安全风控
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/safety-control-capability/riskControl.getUserRiskRank.html
 */
class Client extends BaseClient
{
    /**
     * 获取用户的安全等级
     * riskControl.getUserRiskRank
     * 根据提交的用户信息数据获取用户的安全等级 risk_rank，无需用户授权。
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUserRiskRank(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/getuserriskrank',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}