<?php

namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;

/**
 * 二维码生成
 * Class QrCode
 * @package EasySwoole\WeChat\MiniProgram
 */
class QrCode extends MinProgramBase
{

    /**
     * 二维码 - 永久小程序码
     * @param $path
     * @param int $width
     * @param bool $autoColor
     * @param null $lineColor
     * @param bool $isHyaline
     * @return string
     * @throws InvalidUrl
     * @throws MiniProgramError
     * @throws RequestError
     */
    function getWxaCode($path, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = false)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::WXACODE_GET, [
            'ACCESS_TOKEN' => $token
        ]);
        $data = ['path' => $path, 'width' => $width, 'auto_color' => $autoColor, 'is_hyaline' => $isHyaline];
        if ($lineColor) $data['line_color'] = $lineColor;

        $responseBuffer = NetWork::postJson($url, $data)->getBody();

        // 如果调用成功，会直接返回图片二进制内容，如果请求失败，会返回 JSON 格式的数据
        if (substr($responseBuffer, 0, 1) == "{") {
            $responseData = json_decode($responseBuffer, true);
            if (is_array($responseData)) { // 能解析说明请求失败
                $ex = new MiniProgramError($responseData['errmsg']);
                $ex->setErrorCode($responseData['errcode']);
                throw $ex;
            }
        }


        return $responseBuffer;
    }

    /**
     * 二维码 - 临时小程序码
     * @param $page
     * @param $scene
     * @param int $width
     * @param bool $autoColor
     * @param null $lineColor
     * @param bool $isHyaline
     * @return string
     * @throws InvalidUrl
     * @throws MiniProgramError
     * @throws RequestError
     */
    function getWxaCodeUnLimit($page, $scene, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = false)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::WXACODE_GET_UNLIMITED, [
            'ACCESS_TOKEN' => $token
        ]);
        $data = ['page' => $page, 'width' => $width, 'scene' => $scene, 'auto_color' => $autoColor, 'is_hyaline' => $isHyaline];
        if ($lineColor) $data['line_color'] = $lineColor;

        $responseBuffer = NetWork::postJson($url, $data)->getBody();

        // 如果调用成功，会直接返回图片二进制内容，如果请求失败，会返回 JSON 格式的数据
        if (substr($responseBuffer, 0, 1) == "{") {
            $responseData = json_decode($responseBuffer, true);
            if (is_array($responseData)) { // 能解析说明请求失败
                $ex = new MiniProgramError($responseData['errmsg']);
                $ex->setErrorCode($responseData['errcode']);
                throw $ex;
            }
        }

        return $responseBuffer;
    }

    /**
     * 二维码 - 永久二维码
     * @param $path
     * @param int $width
     * @return string
     * @throws MiniProgramError
     * @throws RequestError
     * @throws InvalidUrl
     */
    function createWxaQrCode($path, $width = 430)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::WXACODE_CREATE_QRCODE, [
            'ACCESS_TOKEN' => $token
        ]);
        $data = ['path' => $path, 'width' => $width];
        $responseBuffer = NetWork::postJson($url, $data)->getBody();

        // 如果调用成功，会直接返回图片二进制内容，如果请求失败，会返回 JSON 格式的数据
        if (substr($responseBuffer, 0, 1) == "{") {
            $responseData = json_decode($responseBuffer, true);
            if (is_array($responseData)) { // 能解析说明请求失败
                $ex = new MiniProgramError($responseData['errmsg']);
                $ex->setErrorCode($responseData['errcode']);
                throw $ex;
            }
        }
        return $responseBuffer;
    }
}