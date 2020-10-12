<?php


namespace EasySwoole\WeChat\Kernel;


use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Utility\AES;
use EasySwoole\WeChat\Kernel\Utility\Random;
use Throwable;

class Encryptor
{
    /**
     * @param string $content
     * @param string $aesKey
     * @param string $appId
     * @return string
     * @throws RuntimeException
     */
    public function encrypt(string $content, string $aesKey, string $appId)
    {
        try {
            $aesKey = $this->decodeAesKey($aesKey);
            $content = self::pkcs7Pad(Random::character(16). pack('N', strlen($content)). $content. $appId);

            return base64_encode(AES::encrypt(
                $content,
                $aesKey,
                $iv = substr($aesKey, 0, 16),
                OPENSSL_NO_PADDING
            ));
        } catch (Throwable $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param string $content
     * @param string $aesKey
     * @param string|null $appId
     * @return false|string
     * @throws RuntimeException
     */
    public function decrypt(string $content, string $aesKey, string $appId = null)
    {
        $aesKey = $this->decodeAesKey($aesKey);

        $decrypted = AES::decrypt(
            base64_decode($content, true),
            $aesKey,
            $iv = substr($aesKey, 0, 16),
            OPENSSL_NO_PADDING
        );
        $result = self::pkcs7Unpad($decrypted);
        $content = substr($result, 16, strlen($result));
        $contentLen = unpack('N', substr($content, 0, 4))[1];

        if (!is_null($appId) && trim(substr($content, $contentLen + 4)) !== $appId) {
            throw new RuntimeException('Invalid appId.');
        }

        return substr($content, 4, $contentLen);
    }

    /**
     * @param string $text
     * @param int $blockSize
     * @return string
     * @throws RuntimeException
     */
    public static function pkcs7Pad(string $text, int $blockSize = 32): string
    {
        if ($blockSize > 256) {
            throw new RuntimeException('$blockSize may not be more than 256');
        }
        $padding = $blockSize - (strlen($text) % $blockSize);
        $pattern = chr($padding);

        return $text.str_repeat($pattern, $padding);
    }

    /**
     * @param string $text
     * @param int $blockSize
     * @return string
     */
    public static function pkcs7Unpad(string $text, int $blockSize = 32): string
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > $blockSize) {
            $pad = 0;
        }

        return substr($text, 0, (strlen($text) - $pad));
    }

    /**
     * @param string $aesKey
     * @return string
     */
    protected function decodeAesKey(string $aesKey):string
    {
        return $aesKey = substr(base64_decode($aesKey . '=', true), 0, 32);
    }
}