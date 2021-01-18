<?php


namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;


class PageClient extends BaseClient
{

    /**
     * @param array $data
     * @return mixed
     * @throws HttpException
     */
    public function create(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/shakearound/page/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $pageId
     * @param array $data
     * @return mixed
     * @throws HttpException
     */
    public function update(int $pageId, array $data)
    {

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(array_merge(['page_id' => $pageId], $data)))
            ->send($this->buildUrl(
                '/shakearound/page/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param array $pageIds
     * @return mixed
     * @throws HttpException
     */
    public function listByIds(array $pageIds)
    {
        $params = [
            'type' => 1,
            'page_ids' => $pageIds,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/page/search',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $begin
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function list(int $begin, int $count)
    {
        $params = [
            'type' => 2,
            'begin' => $begin,
            'count' => $count,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/page/search',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $pageId
     * @return mixed
     * @throws HttpException
     */
    public function delete(int $pageId)
    {
        $params = [
            'page_id' => $pageId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/page/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
