<?php


namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{

    /**
     * @param array $data
     * @return mixed
     * @throws HttpException
     */
    public function register(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/shakearound/account/register',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @return mixed
     * @throws HttpException
     */
    public function status()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/shakearound/account/auditstatus',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param string $ticket
     * @param bool $needPoi
     * @return mixed
     * @throws HttpException
     */
    public function user(string $ticket, bool $needPoi = false)
    {
        $params = [
            'ticket' => $ticket,
        ];

        if ($needPoi) {
            $params['need_poi'] = 1;
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/user/getshakeinfo',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param string $ticket
     * @return mixed
     * @throws HttpException
     */
    public function userWithPoi(string $ticket)
    {
        return $this->user($ticket, true);
    }
}