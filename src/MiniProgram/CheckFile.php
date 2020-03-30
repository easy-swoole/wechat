<?php
/**
 *
 * User: zs
 * Date: 2019/7/9 22:56
 * Email: <1769360227@qq.com>
 */


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Bean\MiniProgram\ImgUpload as ImgUploadBean;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;


class CheckFile extends MinProgramBase
{
    /**
     * 校验一张图片是否含有违法违规内容
     * @param ImgUploadBean $imgUpload
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function imgSecCheck(ImgUploadBean $imgUpload)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::IMG_SEC_CHECK,[
            'ACCESS_TOKEN'  => $token
        ]);

        $data = [
            'media' => $imgUpload
        ];

        $response = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }

    /**
     * 异步校验图片/音频是否含有违法违规内容。
     * @param string $mediaUrl
     * @param int $mediaType
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function mediaCheckAsync(string $mediaUrl ,int $mediaType)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::MEDIA_CHECK_ASYNC,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'media_url'     => $mediaUrl,
            'media_type'    => $mediaType
        ];

        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 检查一段文本是否含有违法违规内容
     * @param string $content
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function msgSecCheck(string $content)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::MSG_SEC_CHECK,[
            'ACCESS_TOKEN'  => $token
        ]);

        $data = [
            'content'   => $content
        ];
        $response  = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;
    }

}