<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Bean\MiniProgram\AddOrder;
use EasySwoole\WeChat\Bean\MiniProgram\UpdatePath;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;

class LogisticsService extends MinProgramBase
{
    /**
     * 获取面单联系人信息
     * @param string $tokens
     * @param string $waybillId
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getContact(string $tokens ,string $waybillId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_CONTACT,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'token'         => $tokens,
            'waybill_id'    => $waybillId
        ];

        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 预览面单模板。用于调试面单模板使用。
     * @param string $waybillId
     * @param string $waybillTemplate
     * @param string $waybillData
     * @param AddOrder $addOrder
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function previewTemplate(string $waybillId ,string $waybillTemplate ,string $waybillData,AddOrder $addOrder)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::PREVIEW_TEMPLATE,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'waybill_id'        => $waybillId,
            'waybill_template'  => $waybillTemplate,
            'waybill_data'      => $waybillData,
            'custom'            => $addOrder
        ];

        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 更新商户审核结果
     * @param string $shopAppId
     * @param string $bizId
     * @param int $resultCode
     * @param string $resultMsg
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function updateBusiness(string $shopAppId ,string $bizId ,int $resultCode ,string $resultMsg)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::UPDATE_BUSINESS,[
            'ACCESS_TOKEN'  => $token
        ]);

        $data = [
            'shop_app_id'   => $shopAppId,
            'biz_id'        => $bizId,
            'result_code'   => $resultCode,
            'result_msg'    => $resultMsg

        ];

        $response = NetWork::postForJson($url,$data);
        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }

    /**
     * 更新运单轨迹
     * @param UpdatePath $updatePath
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function updatePath(UpdatePath $updatePath)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::UPDATE_PATH,[
            'ACCESS_TOKEN'  => $token
        ]);

        $response = NetWork::postForJson($url,$updatePath->toArray());

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }

}