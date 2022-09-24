<?php
/**
 * This file is part of EasySwoole.
 *
 * @link https://www.easyswoole.com
 * @document https://www.easyswoole.com
 * @contact https://www.easyswoole.com/Preface/contact.html
 * @license https://github.com/easy-swoole/easyswoole/blob/3.x/LICENSE
 */

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Record;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代商家管理小程序 - 违规和申诉管理 - 获取小程序违规处罚记录
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/record-management/getIllegalRecords.html
     *
     * @param int|null $startTime 查询时间段的开始时间，如果不填，则表示end_time之前90天内的记录
     * @param int|null $endTime 查询时间段的结束时间，如果不填，则表示start_time之后90天内的记录
     *
     * @return mixed
     * @throws HttpException
     */
    public function getIllegalRecords(int $startTime = null, int $endTime = null)
    {
        $params = [];

        if (!is_null($startTime)) {
            $params['start_time'] = $startTime;
        }

        if (!is_null($endTime)) {
            $params['end_time'] = $endTime;
        }

        $client = $this->getClient()
            ->setMethod("POST");

        if (!empty($params)) {
            $client->setBody($this->jsonDataToStream($params));
        }

        $response = $client
            ->send($this->buildUrl(
                "/wxa/getillegalrecords",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代商家管理小程序 - 违规和申诉管理 - 获取小程序申诉记录
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/record-management/getAppealRecords.html
     *
     * @param string $illegalRecordId 违规处罚记录id（通过 getillegalrecords 接口返回的记录id）
     *
     * @return mixed
     * @throws HttpException
     */
    public function getAppealRecords(string $illegalRecordId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['illegal_record_id' => $illegalRecordId]))
            ->send($this->buildUrl(
                "/wxa/getappealrecords",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }
}