<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:24
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\Exception\OpenPlatformError;

class OpenPlatformBase
{
    private $openPlatform;

    function __construct(OpenPlatform $openPlatform)
    {
        $this->openPlatform = $openPlatform;;
    }

    /**
     * OpenPlatformGetter
     * @return OpenPlatform
     */
    public function getOpenPlatform(): OpenPlatform
    {
        return $this->openPlatform;
    }

    /**
     * @param array $response
     * @return mixed
     * @throws OpenPlatformError
     */
    protected function hasException(array $response)
    {
        $ex = OpenPlatformError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }

}