<?php


namespace EasySwoole\WeChat\MiniProgram;


class Encryptor extends MinProgramBase
{
    /**
     * decryptData
     *
     * @param string $sessionKey
     * @param string    $iv
     * @param string $encryptedData
     * @return string
     */
    public function decryptData(string $sessionKey, string $iv, string $encryptedData)
    {
        return openssl_decrypt(base64_decode($encryptedData), "aes-128-cbc", base64_decode($sessionKey), OPENSSL_RAW_DATA, base64_decode($iv));
    }
}