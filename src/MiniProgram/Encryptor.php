<?php


namespace EasySwoole\WeChat\MiniProgram;


class Encryptor extends MinProgramBase
{
    /**
     * decryptData
     *
     * @param string $sessionKey
     * @param string $iv
     * @param string $encryptedData
     * @return array
     */
    public function decryptData(string $sessionKey, string $iv, string $encryptedData): array
    {
        $jsonString = openssl_decrypt(base64_decode($encryptedData), "aes-128-cbc", base64_decode($sessionKey), OPENSSL_RAW_DATA, base64_decode($iv));
        return json_decode($jsonString, true);
    }
}