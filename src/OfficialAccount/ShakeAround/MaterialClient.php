<?php


namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class MaterialClient extends BaseClient
{
    /**
     * @param string $path
     * @param string $type
     * @return mixed
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function uploadImage(string $path, string $type = 'icon')
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf('File does not exist, or the file is unreadable: "%s"', $path));
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->addFile($path, 'media')
            ->send($this->buildUrl(
                '/shakearound/material/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken(), 'type' => strtolower($type)]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}