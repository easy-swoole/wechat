<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:44
 */

namespace EasySwoole\WeChat\Exception;


class JsSdkError extends Exception
{
    private $errorCode;

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param mixed $errorCode
     */
    public function setErrorCode($errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    public static function hasException(array $jsonData):?JsSdkError
    {
        if(isset($jsonData['errcode']) && $jsonData['errcode'] != 0){
            $ex = new JsSdkError($jsonData['errmsg']);
            $ex->setErrorCode($jsonData['errcode']);
            return $ex;
        }
        return null;
    }
}