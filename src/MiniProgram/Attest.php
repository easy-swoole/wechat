<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;

class Attest extends MinProgramBase
{
    /**
     * SOTER 生物认证秘钥签名验证
     * @param string $openid
     * @param string $jsonString
     * @param string $jsonSignature
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function verifySignature(string $openid ,string $jsonString ,string $jsonSignature)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::VERIFY_SIGNATURE,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'openid'        => $openid,
            'json_string'   => $jsonString,
            'json_signature'=> $jsonSignature
        ];

        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

}