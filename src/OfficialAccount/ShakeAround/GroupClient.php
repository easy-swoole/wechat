<?php


namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class GroupClient extends BaseClient
{

    /**
     * @param string $name
     * @return mixed
     * @throws HttpException
     */
    public function create(string $name)
    {
        $params = [
            'group_name' => $name,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $groupId
     * @param string $name
     * @return mixed
     * @throws HttpException
     */
    public function update(int $groupId, string $name)
    {
        $params = [
            'group_id' => $groupId,
            'group_name' => $name,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $groupId
     * @return mixed
     * @throws HttpException
     */
    public function delete(int $groupId)
    {
        $params = [
            'group_id' => $groupId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/delete',
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
            'begin' => $begin,
            'count' => $count,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/getlist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $groupId
     * @param int $begin
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function get(int $groupId, int $begin, int $count)
    {
        $params = [
            'group_id' => $groupId,
            'begin' => $begin,
            'count' => $count,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/getdetail',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $groupId
     * @param array $deviceIdentifiers
     * @return mixed
     * @throws HttpException
     */
    public function addDevices(int $groupId, array $deviceIdentifiers)
    {
        $params = [
            'group_id' => $groupId,
            'device_identifiers' => $deviceIdentifiers,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/adddevice',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $groupId
     * @param array $deviceIdentifiers
     * @return mixed
     * @throws HttpException
     */
    public function removeDevices(int $groupId, array $deviceIdentifiers)
    {
        $params = [
            'group_id' => $groupId,
            'device_identifiers' => $deviceIdentifiers,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/group/deletedevice',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}