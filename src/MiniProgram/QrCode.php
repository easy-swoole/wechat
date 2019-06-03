<?php

namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\HttpClient;

/**
 * 二维码生成
 * Class QrCode
 * @package EasySwoole\WeChat\MiniProgram
 */
class QrCode extends MinProgramBase
{

    /**
     * 生成小程序码接口A
     * @param $path
     * @param int $width
     * @param bool $autoColor
     * @param null $lineColor
     * @param bool $isHyaline
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    function getWxaCode($path, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = false)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::QRCODE_GETWXACODE, [
            'ACCESS_TOKEN' => $token
        ]);
        $data = ['path' => $path, 'width' => $width, 'auto_color' => $autoColor, 'is_hyaline' => $isHyaline];
        if ($lineColor) $data['line_color'] = $lineColor;

        $responseArray = HttpClient::postForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 生成小程序码接口B - 不限数量
     * @param $path
     * @param $scene
     * @param int $width
     * @param bool $autoColor
     * @param null $lineColor
     * @param bool $isHyaline
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    function getWxaCodeUnLimit($path, $scene, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = false)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::QRCODE_GETWXACODE_UNLIMIT, [
            'ACCESS_TOKEN' => $token
        ]);
        $data = ['path' => $path, 'width' => $width, 'scene' => $scene, 'auto_color' => $autoColor, 'is_hyaline' => $isHyaline];
        if ($lineColor) $data['line_color'] = $lineColor;

        $responseArray = HttpClient::postForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 生成小程序码接口C
     * @param $path
     * @param int $width
     * @return mixed
     * @throws MiniProgramError
     * @throws RequestError
     */
    function createWxaQrCode($path, $width = 430)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::QRCODE_CREATE_WXACODE, [
            'ACCESS_TOKEN' => $token
        ]);
        $data = ['path' => $path, 'width' => $width];
        $responseArray = HttpClient::postForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }
}