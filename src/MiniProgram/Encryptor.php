<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Exception\EncryptorError;

class Encryptor extends MinProgramBase
{
    /**
     * @param string $sessionKey
     * @param string $iv
     * @param string $encryptedData
     * @return array
     * @throws EncryptorError
     */
    public function decryptData(string $sessionKey, string $iv, string $encryptedData): array
    {
        $jsonString = openssl_decrypt(base64_decode($encryptedData), "aes-128-cbc", base64_decode($sessionKey), OPENSSL_RAW_DATA, base64_decode($iv));

        $decryptData = json_decode($jsonString, true);

        if (!$decryptData) {
            throw new EncryptorError('The given payload is invalid.');
        }

        return $decryptData;
    }
}