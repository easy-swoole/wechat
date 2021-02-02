<?php


namespace EasySwoole\WeChat\OfficialAccount\Device;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @package EasySwoole\WeChat\OfficialAccount\Device
 * @link https://iot.weixin.qq.com/wiki/new/index.html?page=3-4-13
 * @author gaobinzhan <gaobinzhan@gmail.com>
 * 微信文档是真的找不到。。。
 */
class Client extends BaseClient
{

    /**
     * @param string $deviceId
     * @param string $openid
     * @param string $content
     * @param string|null $deviceType
     * @return bool
     * @throws HttpException
     */
    public function message(string $deviceId, string $openid, string $content, string $deviceType = null)
    {
        $params = [
            'device_type' => $this->app[ServiceProviders::Config]->get('device_type') ?? $deviceType,
            'device_id' => $deviceId,
            'open_id' => $openid,
            'content' => base64_encode($content),
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/transmsg',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * @param array $deviceIds
     * @return mixed
     * @throws HttpException
     */
    public function qrCode(array $deviceIds)
    {
        $params = [
            'device_num' => count($deviceIds),
            'device_id_list' => $deviceIds,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/create_qrcode',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $devices
     * @param string $productId
     * @param int $opType
     * @return mixed
     * @throws HttpException
     */
    public function authorize(array $devices, string $productId, int $opType = 0)
    {
        $params = [
            'device_num' => count($devices),
            'device_list' => $devices,
            'op_type' => $opType,
            'product_id' => $productId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/authorize_device',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 获取 device id 和二维码
     * @param string $productId
     * @return mixed
     * @throws HttpException
     */
    public function createId(string $productId)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/device/getqrcode',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
                    'product_id' => $productId
                ]
            ));

        $this->checkResponse($response, $parseData, false);

        if (isset($parseData['resp_msg']['ret_code']) && (int)$parseData['resp_msg']['ret_code'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$parseData['resp_msg']['ret_code']}) {$parseData['resp_msg']['error_info']}",
                $response,
                $parseData['resp_msg']['ret_code']
            );
        }

        return $parseData;
    }

    /**
     * @param string $openid
     * @param string $deviceId
     * @param string $ticket
     * @return bool
     * @throws HttpException
     */
    public function bind(string $openid, string $deviceId, string $ticket)
    {
        $params = [
            'ticket' => $ticket,
            'device_id' => $deviceId,
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/bind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData, false);

        if (isset($parseData['base_resp']['errcode']) && (int)$parseData['base_resp']['errcode'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$parseData['base_resp']['errcode']}) {$parseData['base_resp']['errmsg']}",
                $response,
                $parseData['base_resp']['errmsg']
            );
        }

        return true;
    }

    /**
     * @param string $openid
     * @param string $deviceId
     * @param string $ticket
     * @return bool
     * @throws HttpException
     */
    public function unbind(string $openid, string $deviceId, string $ticket)
    {
        $params = [
            'ticket' => $ticket,
            'device_id' => $deviceId,
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/unbind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData, false);

        if (isset($parseData['base_resp']['errcode']) && (int)$parseData['base_resp']['errcode'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$parseData['base_resp']['errcode']}) {$parseData['base_resp']['errmsg']}",
                $response,
                $parseData['base_resp']['errmsg']
            );
        }

        return true;
    }

    /**
     * @param string $openid
     * @param string $deviceId
     * @return bool
     * @throws HttpException
     */
    public function forceBind(string $openid, string $deviceId)
    {
        $params = [
            'device_id' => $deviceId,
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/compel_bind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData, false);

        if (isset($parseData['base_resp']['errcode']) && (int)$parseData['base_resp']['errcode'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$parseData['base_resp']['errcode']}) {$parseData['base_resp']['errmsg']}",
                $response,
                $parseData['base_resp']['errmsg']
            );
        }

        return true;
    }

    /**
     * @param string $openid
     * @param string $deviceId
     * @return bool
     * @throws HttpException
     */
    public function forceUnbind(string $openid, string $deviceId)
    {
        $params = [
            'device_id' => $deviceId,
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/compel_unbind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData, false);

        if (isset($parseData['base_resp']['errcode']) && (int)$parseData['base_resp']['errcode'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$parseData['base_resp']['errcode']}) {$parseData['base_resp']['errmsg']}",
                $response,
                $parseData['base_resp']['errmsg']
            );
        }

        return true;
    }

    /**
     * @param string $deviceId
     * @return mixed
     * @throws HttpException
     */
    public function status(string $deviceId)
    {
        $params = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'device_id' => $deviceId,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/device/get_stat',
                $params
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param string $ticket
     * @return mixed
     * @throws HttpException
     */
    public function verify(string $ticket)
    {
        $params = [
            'ticket' => $ticket,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/device/verify_qrcode',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param string $deviceId
     * @param string|null $deviceType
     * @return mixed
     * @throws HttpException
     */
    public function openid(string $deviceId, string $deviceType = null)
    {
        $params = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'device_type' => $this->app[ServiceProviders::Config]->get('device_type') ?? $deviceType,
            'device_id' => $deviceId,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/device/get_openid',
                $params
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param string $openid
     * @return mixed
     * @throws HttpException
     */
    public function listByOpenid(string $openid)
    {
        $params = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/device/get_bind_device',
                $params
            ));

        $this->checkResponse($response, $parseData, false);

        if (isset($parseData['resp_msg']['ret_code']) && (int)$parseData['resp_msg']['ret_code'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$parseData['resp_msg']['ret_code']}) {$parseData['resp_msg']['error_info']}",
                $response,
                $parseData['resp_msg']['ret_code']
            );
        }

        return $parseData;
    }

    protected function checkResponse(ResponseInterface $response, &$parseData = null, bool $verifyData = true): bool
    {
        if (!in_array($response->getStatusCode(), [200])) {
            throw new HttpException(
                $response->getBody()->__toString(),
                $response
            );
        }

        $data = $this->parseData($response);
        $parseData = $data;

        if ($verifyData === false) {
            return true;
        }

        if (isset($data['errcode']) && (int)$data['errcode'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$data['errcode']}) {$data['errmsg']}",
                $response,
                $data['errcode']
            );
        }

        return true;
    }
}