<?php



namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Material;



use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;


class Client extends BaseClient
{
    /**
     * Allow media type.
     *
     * @var array
     */
    protected $allowTypes = ['image', 'voice', 'video', 'thumb', 'news_image'];

    /**
     * @param string $mediaId
     * @return StreamResponse
     * @throws HttpException
     */
    public function get(string $mediaId)
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->setBody($this->jsonDataToStream(['media_id' => $mediaId]))
            ->send($this->buildUrl(
                "/cgi-bin/material/get_material",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        $this->checkResponse($response);
    }
}
