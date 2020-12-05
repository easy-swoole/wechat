<?php


namespace EasySwoole\WeChat\OfficialAccount\CustomerService;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    public function list()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/customservice/getkflist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function online()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/customservice/getonlinekflist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function create(string $account, string $nickname)
    {
        $params = [
            'kf_account' => $account,
            'nickname' => $nickname,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/customservice/kfaccount/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function update(string $account, string $nickname)
    {
        $params = [
            'kf_account' => $account,
            'nickname' => $nickname,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/customservice/kfaccount/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function delete(string $account)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['kf_account' => $account]))
            ->send($this->buildUrl(
                '/customservice/kfaccount/del',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function invite(string $account, string $wechatId)
    {
        $params = [
            'kf_account' => $account,
            'invite_wx' => $wechatId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/customservice/kfaccount/inviteworker',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function setAvatar(string $account, string $path)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['kf_account' => $account]))
            ->addFile($path, 'media')
            ->send($this->buildUrl(
                '/customservice/kfaccount/uploadheadimg',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function send(array $message)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($message))
            ->send($this->buildUrl(
                '/cgi-bin/message/custom/send',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function showTypingStatusToUser(string $openid)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'touser' => $openid,
                'command' => 'Typing',
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/message/custom/typing',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function hideTypingStatusToUser(string $openid)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'touser' => $openid,
                'command' => 'CancelTyping',
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/message/custom/typing',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function messages($startTime, $endTime, int $msgId = 1, int $number = 10000)
    {
        $params = [
            'starttime' => is_numeric($startTime) ? $startTime : strtotime($startTime),
            'endtime' => is_numeric($endTime) ? $endTime : strtotime($endTime),
            'msgid' => $msgId,
            'number' => $number,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/customservice/msgrecord/getmsglist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}