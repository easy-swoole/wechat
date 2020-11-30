<?php


namespace EasySwoole\WeChat\OfficialAccount\Material;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Messages\Article;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /** @var string[] */
    protected $allowTypes = ['image', 'voice', 'video', 'thumb', 'news_image'];

    /**
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadImage(string $path)
    {
        return $this->upload('image', $path);
    }

    /**
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadVoice(string $path)
    {
        return $this->upload('voice', $path);
    }

    /**
     * @param string $path
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadThumb(string $path)
    {
        $this->upload('thumb', $path);
    }

    /**
     * @param string $path
     * @param string $title
     * @param string $description
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadVideo(string $path, string $title, string $description)
    {
        $formData = [
            'description' => json_encode(
                [
                    'title' => $title,
                    'introduction' => $description,
                ],
                JSON_UNESCAPED_UNICODE
            ),
        ];
        return $this->upload('video', $path, $formData);
    }

    /**
     * @param $articles
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadArticle($articles)
    {
        if ($articles instanceof Article || !empty($articles['title'])) {
            $articles = [$articles];
        }

        $params = ['articles' => array_map(function ($article) {
            if ($article instanceof Article) {
                return $article->transformForJsonRequest();
            }

            return $article;
        }, $articles)];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/material/add_news',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $mediaId
     * @param $article
     * @param int $index
     * @return bool
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function updateArticle(string $mediaId, $article, int $index = 0)
    {
        if ($article instanceof Article) {
            $article = $article->transformForJsonRequest();
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'media_id' => $mediaId,
                'index' => $index,
                'articles' => isset($article['title']) ? $article : (isset($article[$index]) ? $article[$index] : []),
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/material/update_news',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response);
        return true;
    }

    /**
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadArticleImage(string $path)
    {
        return $this->upload('news_image', $path);
    }

    /**
     * @param string $type
     * @param string $path
     * @param array $formData
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function upload(string $type, string $path, array $formData = [])
    {
        if (!in_array($type, $this->allowTypes, true)) {
            throw new InvalidArgumentException(sprintf("Unsupported media type: '%s'", $type));
        }

        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf("File does not exist, or the file is unreadable: '%s'", $path));
        }

        $client = $this->getClient()->setMethod('POST')->addFile($path, 'media');

        foreach ($formData as $key => $value) {
            $client = $client->addData($value, $key);
        }

        $response = $client->send($this->buildUrl(
            $this->getApiByType($type),
            [
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
                'type' => $type
            ]
        ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $mediaId
     * @return mixed
     * @throws HttpException
     */
    public function get(string $mediaId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['media_id' => $mediaId]))
            ->send($this->buildUrl(
                '/cgi-bin/material/get_material',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $mediaId
     * @return bool
     * @throws HttpException
     */
    public function delete(string $mediaId): bool
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['media_id' => $mediaId]))
            ->send($this->buildUrl(
                '/cgi-bin/material/del_material',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response);
        return true;
    }

    /**
     * @param string $type
     * @param int $offset
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function list(string $type, int $offset = 0, int $count = 20)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'type' => $type,
                'offset' => $offset,
                'count' => $count,
            ]))->send($this->buildUrl(
                '/cgi-bin/material/batchget_material',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function stats()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/material/get_materialcount',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getApiByType(string $type)
    {
        switch ($type) {
            case 'news_image':
                return '/cgi-bin/media/uploadimg';
            default:
                return '/cgi-bin/material/add_material';
        }
    }
}