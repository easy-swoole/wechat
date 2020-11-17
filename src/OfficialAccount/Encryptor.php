<?php
/**
 * Created by PhpStorm.
 * User: runstp
 * Date: 2019-06-17
 * Time: 10:30
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Exception\EncryptorError;

/**
 * Class Encryptor
 * 专属 公众号加解密
 * 碎碎念 这个破玩意不想写第二次
 * @package EasySwoole\WeChat\OfficialAccount
 */
class Encryptor
{
    /**
     * decrypt
     *
     * @param string $appId
     * @param string $data
     * @param string $aesKey
     * @return string
     * @throws EncryptorError
     */
    public static function decrypt(string $appId, string $data, string $aesKey): string
    {
        // 加等于号末尾做base64decode 得到32位的binKey
        $aesKey = substr(base64_decode($aesKey . '=', true), 0, 32);
        // 前16位为iv
        $iv = substr($aesKey, 0, 16);
        // OPENSSL_ZERO_PADDING 使用0补位
        $data = openssl_decrypt(base64_decode($data), "aes-256-cbc", $aesKey, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

        if (openssl_error_string() !== false) {
            throw new EncryptorError(openssl_error_string());
        }

        // 删除补位字符
        $data = self::decodePKCS($data);

        // 16位以后是内容
        $data = substr($data, 16, strlen($data));
        // 前4位是有效数据长度
        $dataLength = unpack("N", substr($data, 0, 4))[1];

        // 获取包中的appId
        $dataAppId = substr($data, $dataLength + 4, strlen($appId));

        // 验证消息的appId是否正确
        if ($appId !== $dataAppId) {
            throw new EncryptorError('消息appId验证失败.');
        }

        // 返回有效包体内容
        return substr($data, 4, $dataLength);
    }

    /**
     * encrypt
     *
     * @param string $appId
     * @param string $data
     * @param string $aesKey
     * @return string
     * @throws EncryptorError
     */
    public static function encrypt(string $appId, string $data, string $aesKey): string
    {
        // 删除两边换行字符
        $data = trim($data, "\n");

        // 生成16位置随机字符串
        $character = self::character(16);
        // 拼接包
        $data = $character . pack('N', strlen($data)) . $data . $appId;
        // pkcs7 补位
        $data = self::encodePKCS($data);

        // 加等于号末尾做base64decode 得到32位的binKey
        $aesKey = substr(base64_decode($aesKey . '=', true), 0, 32);
        // 前16位为iv
        $iv = substr($aesKey, 0, 16);
        // 加密
        $data = openssl_encrypt($data, "aes-256-cbc", $aesKey, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

        if (openssl_error_string() !== false) {
            throw new EncryptorError(openssl_error_string());
        }

        // base64 编码
        return base64_encode($data);
    }

    /**
     * character
     *
     * @param int    $length
     * @param string $alphabet
     * @return bool|string
     */
    public static function character($length = 6, $alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789')
    {
        /*
         * mt_srand() is to fix:
            mt_rand(0,100);
            if(pcntl_fork()){
                var_dump(mt_rand(0,100));
            }else{
                var_dump(mt_rand(0,100));
            }
         */
        mt_srand();
        // 重复字母表以防止生成长度溢出字母表长度
        if ($length >= strlen($alphabet)) {
            $rate = intval($length / strlen($alphabet)) + 1;
            $alphabet = str_repeat($alphabet, $rate);
        }

        // 打乱顺序返回
        return substr(str_shuffle($alphabet), 0, $length);
    }

    /**
     * PKCS补位
     *
     * @param string $data      需要操作补位的数据
     * @param int    $blockSize PKCS#5 = 8 OTHER IS PKCS#7
     * @return string
     */
    public static function encodePKCS($data, $blockSize = 32)
    {
        $pad = $blockSize - (strlen($data) % $blockSize);
        // 如果本次操作的数据正好是块大小的整倍数 则补上块大小个字节的补位
        if ($pad == 0) {
            $pad = $blockSize;
        }
        return $data . str_repeat(chr($pad), $pad);
    }

    /**
     * PKCS 移除补位
     *
     * @param string $data
     * @return bool|string
     */
    public static function decodePKCS($data)
    {
        // 根据PKCS 补位时如果为整数倍块大小 则补上块大小个字节的补位 最后一位必是补位字节
        $pad = ord($data[strlen($data) - 1]);
        if ($pad > strlen($data)) {
            return false;
        }
        if (strspn($data, chr($pad), strlen($data) - $pad) != $pad) {
            return false;
        }
        return substr($data, 0, -1 * $pad);
    }
}