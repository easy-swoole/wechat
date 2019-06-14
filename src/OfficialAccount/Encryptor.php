<?php


namespace EasySwoole\WeChat\OfficialAccount;


class Encryptor
{
    /**
     * decrypt
     *
     * @param string $data
     * @param string $aesKey
     * @return string
     */
    public static function decrypt(string $data, string $aesKey): string
    {
        // 加等于号末尾做base64decode 得到32位的binKey
        $aesKey = substr(base64_decode($aesKey . '=', true), 0, 32);
        // 前16位为iv
        $iv = substr($aesKey, 0, 16);
        // OPENSSL_ZERO_PADDING 使用0补位
        $data = openssl_decrypt(base64_decode($data), "aes-256-cbc", $aesKey, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

        // 16位以后是内容
        $data = substr($data, 16, strlen($data));
        // 前4位是有效数据长度
        $dataLength = unpack("N", substr($data, 0, 4))[1];
        // 返回有效包体内容
        return substr($data, 4, $dataLength);
    }

    /**
     * encrypt
     *
     * @param string $data
     * @param string $aesKey
     * @return string
     */
    public static function encrypt(string $data, string $aesKey): string
    {
        // 获取有效内容长度
        $dataLength = strlen($data);
        // 生成16位置随机字符串
        $character = self::character(16);
        // 拼接包
        $data = $character. pack('N', $dataLength). $data;

        // 加等于号末尾做base64decode 得到32位的binKey
        $aesKey = substr(base64_decode($aesKey . '=', true), 0, 32);
        // 前16位为iv
        $iv = substr($aesKey, 0, 16);

        // 加密
        $data = openssl_encrypt($data, "aes-256-cbc", $aesKey, OPENSSL_RAW_DATA, $iv);
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
    private static function character($length = 6, $alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789')
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
}