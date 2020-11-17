<?php


namespace EasySwoole\WeChat\OfficialAccount\Broadcasting;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /**
     * @param array $message
     * @return array
     * @throws HttpException
     */
    public function send(array $message): array
    {
        $path = isset($message['touser']) ? 'cgi-bin/message/mass/send' : 'cgi-bin/message/mass/sendall';

        $response = $this->getClient()->setMethod("POST")
            ->setBody($this->jsonDataToStream($message))
            ->send($this->buildUrl(
                $path,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * @param MessageInterface $message
     * @param null $reception
     * @return array
     * @throws HttpException
     */
    public function sendMessage(MessageInterface $message, $reception = null): array
    {
        // TODO: build message
        return $this->send($message->transformForJsonRequest());
    }

    /**
     * @param string $msgId
     * @return array
     * @throws HttpException
     */
    public function status(string $msgId): array
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'msg_id' => $msgId
            ]))->send($this->buildUrl(
                '/cgi-bin/message/mass/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * @param string $msgId
     * @param int $index
     * @return bool
     * @throws HttpException
     */
    public function delete(string $msgId, int $index = 0): bool
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'msg_id' => $msgId,
                'article_idx' => $index
            ]))->send($this->buildUrl(
                '/cgi-bin/message/mass/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response, $jsonData);
    }
}