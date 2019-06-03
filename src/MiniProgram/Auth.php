<?php


namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\HttpClient;

/**
 * Class Auth
 *
 * @package EasySwoole\WeChat\MiniProgram
 */
class Auth extends MinProgramBase
{
    /**
     * session
     *
     * @param string $code
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    public function session(string $code) : array
    {
        $url = ApiUrl::generateURL(ApiUrl::JSCODE2_SESSION, [
            'APPID' => $this->getMiniProgram()->getConfig()->getAppId(),
            'SECRET' => $this->getMiniProgram()->getConfig()->getAppSecret(),
            'JSCODE' => $code
        ]);

        $responseArray = HttpClient::getForJson($url);
        $ex = MiniProgramError::hasException($responseArray);
        if($ex){
            throw $ex;
        }

        return $responseArray;
    }
}