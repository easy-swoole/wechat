<?php
declare(strict_types=1);

/**
 ***********作者信息**********
 * Author: ysongyang
 * Email: 49271743@qq.com
 * Desc: 违规和申诉管理
 * Date: 2022/9/19 13:25
 *****************************
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
     * @param int $start_time 查询时间段的开始时间，如果不填，则表示end_time之前90天内的记录
     * @param int $end_time 查询时间段的结束时间，如果不填，则表示start_time之后90天内的记录
     * @return mixed
     * @throws HttpException
     */
    public function getIllegalRecords(int $start_time = 0, int $end_time = 0)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['start_time' => $start_time, 'end_time' => $end_time]))
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
     * @param string $illegal_record_id 违规处罚记录id（通过 getillegalrecords 接口返回的记录id）
     * @return mixed
     * @throws HttpException
     */
    public function getAppealRecords(string $illegal_record_id)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['illegal_record_id' => $illegal_record_id]))
            ->send($this->buildUrl(
                "/wxa/getappealrecords",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }
}