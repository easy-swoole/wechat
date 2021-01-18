<?php


namespace EasySwoole\WeChat\OfficialAccount\Comment;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class Client extends BaseClient
{

    /**
     * @param string $msgId
     * @param int|null $index
     * @return bool
     * @throws HttpException
     */
    public function open(string $msgId, int $index = null)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/open',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }


    /**
     * @param string $msgId
     * @param int|null $index
     * @return bool
     * @throws HttpException
     */
    public function close(string $msgId, int $index = null)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/close',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }


    /**
     * @param string $msgId
     * @param int $index
     * @param int $begin
     * @param int $count
     * @param int $type
     * @return mixed
     * @throws HttpException
     */
    public function list(string $msgId, int $index, int $begin, int $count, int $type = 0)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
            'begin' => $begin,
            'count' => $count,
            'type' => $type,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param string $msgId
     * @param int $index
     * @param int $commentId
     * @return bool
     * @throws HttpException
     */
    public function markElect(string $msgId, int $index, int $commentId)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
            'user_comment_id' => $commentId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/markelect',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }


    /**
     * @param string $msgId
     * @param int $index
     * @param int $commentId
     * @return bool
     * @throws HttpException
     */
    public function unmarkElect(string $msgId, int $index, int $commentId)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
            'user_comment_id' => $commentId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/unmarkelect',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }


    /**
     * @param string $msgId
     * @param int $index
     * @param int $commentId
     * @return bool
     * @throws HttpException
     */
    public function delete(string $msgId, int $index, int $commentId)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
            'user_comment_id' => $commentId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * @param string $msgId
     * @param int $index
     * @param int $commentId
     * @param string $content
     * @return bool
     * @throws HttpException
     */
    public function reply(string $msgId, int $index, int $commentId, string $content)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
            'user_comment_id' => $commentId,
            'content' => $content,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/reply/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * @param string $msgId
     * @param int $index
     * @param int $commentId
     * @return bool
     * @throws HttpException
     */
    public function deleteReply(string $msgId, int $index, int $commentId)
    {
        $params = [
            'msg_data_id' => $msgId,
            'index' => $index,
            'user_comment_id' => $commentId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/comment/reply/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}