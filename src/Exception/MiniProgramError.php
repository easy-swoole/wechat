<?php


namespace EasySwoole\WeChat\Exception;


class MiniProgramError extends Exception
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
     * @return MiniProgramError|null
     */
    public static function hasException(array $jsonData): ?MiniProgramError
    {
        if (isset($jsonData['errcode']) && $jsonData['errcode'] != 0) {
            $ex = new MiniProgramError($jsonData['errmsg']);
            $ex->setErrorCode($jsonData['errcode']);
            return $ex;
        }
        return null;
    }
}