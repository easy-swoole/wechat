<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class MeetingTicketClient extends BaseClient
{
    public function updateUser(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/meetingticket/updateuser',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}