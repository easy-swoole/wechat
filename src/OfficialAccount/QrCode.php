<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:25 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\WeChat\Bean\OfficialAccount\QrCodeRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\QrCode as QrCodeBean;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;

class QrCode extends OfficialAccountBase
{
    /**
     * 获取二维码TICKET
     * @param QrCodeRequest $codeRequest
     * @return QrCodeBean|null
     * @throws OfficialAccountError
     * @throws InvalidUrl
     * @throws RequestError
     */
    function getTick(QrCodeRequest $codeRequest): ?QrCodeBean
    {
        $token = $this->getOfficialAccount()->accessToken()->getToken();
        $response = NetWork::postJsonForJson(ApiUrl::generateURL(ApiUrl::QRCODE_CREATE, [
            'ACCESS_TOKEN' => $token
        ]), $codeRequest->buildRequest());

        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            return new QrCodeBean($response);
        }
    }

    /**
     * 二维码TICKET换取图片URL
     * @param QrCodeBean $code
     * @return string|null
     */
    public static function tickToImageUrl(QrCodeBean $code): ?string
    {
        return ApiUrl::generateURL(ApiUrl::SHOW_QRCODE, [
            'TICKET' => $code->getTicket()
        ]);
    }

    /**
     * 将一条长链接转成短链接
     *
     * @param string $url
     *
     * @return null|string
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function shorturl(string $url): ?string
    {

        $response = NetWork::postJsonForJson(ApiUrl::generateURL(ApiUrl::SHORT_URL, [
            'ACCESS_TOKEN' =>  $this->getOfficialAccount()->accessToken()->getToken()
        ]), [
            'action'   => 'long2short',
            'long_url' => $url
        ]);

        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            return $response['short_url'];
        }
    }


}