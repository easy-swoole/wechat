<?php
/**
 *
 * User: zs
 * Date: 2019/7/8
 * Email: <1769360227@qq.com>
 */


namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Bean\MiniProgram\Program as ProgramBean;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;

class Program extends MinProgramBase
{
    /**
     * 添加地点
     * @param ProgramBean $program
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function add(ProgramBean $program)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::ADD,[
            'ACCESS_TOKEN'  => $token
        ]);

        $responseArray = NetWork::postForJson($url,$program->toArray());

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 删除地点
     * @param string $poiId
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function delete(string  $poiId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::DELETE,[
           'ACCESS_TOKEN'   => $token
        ]);
        $data = [
            'poi_id' => $poiId
        ];

        $response = NetWork::postForJson($url,$data);
        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }

    /**
     * 查看地点列表
     * @param int $page
     * @param int $pageRows
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getList(int $page = 1 ,int $pageRows)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_LIST,[
            'ACCESS_TOKEN'  => $token,
            'PAGE'          => $page,
            'PAGE_ROWS'     => $pageRows
        ]);

        $responseArray = NetWork::get($url);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 展示/取消展示附近小程序
     * @param string $poiId
     * @param int $status
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function setShowStatus(string $poiId ,int $status)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::SET_SHOW_STATUS,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'poi_id'    => $poiId,
            'status'    => $status
        ];

        $response = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }
}