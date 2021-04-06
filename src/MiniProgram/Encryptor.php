<?php

namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Kernel\Encryptor as BaseEncryptor;
use EasySwoole\WeChat\Kernel\Exceptions\DecryptException;
use EasySwoole\WeChat\Kernel\Utility\AES;

/**
 * Class Encryptor
 * @package EasySwoole\WeChat\MiniProgram
 */
class Encryptor extends BaseEncryptor
{
    /**
     * Decrypt data.
     *
     * @param string $sessionKey
     * @param string $iv
     * @param string $encrypted
     *
     * @return array
     *
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\DecryptException
     */
    public function decryptData(string $sessionKey, string $iv, string $encrypted): array
    {
        $decrypted = AES::decrypt(
            base64_decode($encrypted, false),
            base64_decode($sessionKey, false),
            base64_decode($iv, false)
        );

        $decrypted = json_decode($decrypted, true);

        if (!$decrypted) {
            throw new DecryptException('The given payload is invalid.');
        }

        return $decrypted;
    }
}
