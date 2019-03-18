<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:26
 */

namespace EasySwoole\WeChat\Exception;

class OpenPlatformError extends Exception
{
    private $errorCode;

    /**
     * ErrorCodeGetter
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * ErrorCodeSetter
     * @param mixed $errorCode
     */
    public function setErrorCode($errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * Check the response has exception
     * @param array $jsonData
     * @return OpenPlatformError|null
     */
    public static function hasException(array $jsonData): ?OpenPlatformError
    {
        if (isset($jsonData['errcode']) && $jsonData['errcode'] != 0) {
            $ex = new OpenPlatformError($jsonData['errmsg']);
            $ex->setErrorCode($jsonData['errcode']);
            return $ex;
        }
        return null;
    }
}