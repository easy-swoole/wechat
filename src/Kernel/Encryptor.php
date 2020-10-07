<?php


namespace EasySwoole\WeChat\Kernel;


class Encryptor
{
    protected $appId;
    protected $token;
    protected $aesKey;

    /**
     * Encryptor constructor.
     *
     * @param string      $appId
     * @param string|null $token
     * @param string|null $aesKey
     */
    public function __construct(string $appId, string $token = null, string $aesKey = null)
    {
        $this->appId = $appId;
        $this->token = $token;
        $this->aesKey = base64_decode($aesKey.'=', true);
    }
}