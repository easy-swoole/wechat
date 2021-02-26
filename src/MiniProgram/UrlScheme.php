<?php

declare(strict_types=1);


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;

class UrlScheme extends MinProgramBase
{
    /**
     * 生成URL SCHEME
     * @param string $path
     * @param string $query
     * @param bool $isExpire
     * @param int $expireAt
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    public function generate(string $path, string $query, bool $isExpire = false, int $expireAt = 0)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::URL_SCHEME_GENERATE, [
            'ACCESS_TOKEN' => $token,
        ]);

        $responseArray = NetWork::postJsonForJson($url, [
            'jump_wxa'     => [
                'path'  => $path,
                'query' => $query
            ],
            'is_expire'    => $isExpire,
            'expire_time'  => $expireAt
        ]);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }
}