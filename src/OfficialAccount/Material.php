<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-8
 * Time: 上午10:37
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\Utility\Mime\MimeDetectorException;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaArticle;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaResponse;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;

/**
 * Class Material
 *
 * @package EasySwoole\WeChat\OfficialAccount
 */
class Material extends Media
{

    /**
     * 上传永久素材
     * @param MediaRequest $mediaBean
     * @return array
     * @throws OfficialAccountError
     * @throws InvalidUrl
     * @throws MimeDetectorException
     * @throws RequestError
     */
    public function upload(MediaRequest $mediaBean)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_UPLOAD, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken(),
            'TYPE'         => $mediaBean->getType()
        ]);

        // video type additional parameters
        if ($mediaBean->getType() === MediaRequest::TYPE_VIDEO) {
            $form = ['description' => $mediaBean->getDescription()];
        }

        return $this->uploadMedia($url, $this->crateFileBean($mediaBean), $form ?? null);
    }

    /**
     * 获取永久素材
     * @param $mediaId
     * @return \EasySwoole\HttpClient\Bean\Response|MediaResponse|mixed
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function get($mediaId)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_GET, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        return $this->getMedia($url, ['media_id' => $mediaId]);
    }

    /**
     * 删除永久素材
     * @param $mediaId
     * @return array
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function delete($mediaId)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_DELETE, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, ['media_id' => $mediaId]);
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }


    /**
     * 获取永久素材数量
     * @return array
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function stats()
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_COUNT, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::getForJson($url);
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }

    /**
     * 获取永久素材列表
     * @param string $mediaType
     * @param int $offset
     * @param int $count
     * @return array
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function list(string $mediaType, int $offset = 0, int $count = 20)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_LIST, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'type'   => $mediaType,
            'offset' => $offset,
            'count'  => $count
        ];

        $response = NetWork::postJsonForJson($url, $postData);
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }

    /**
     * 上传多个永久图文素材
     * @param MediaArticle ...$articles
     * @return array
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function uploadArticle(MediaArticle ...$articles)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_UPLOAD_NEWS, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = ['articles' => []];
        foreach ($articles as $article) {
            array_push($postData['articles'], $article->toArray(null, MediaArticle::FILTER_NOT_NULL));
        }

        $response = NetWork::postJsonForJson($url, $postData);
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }

    /**
     * 更新永久素材
     * @param $mediaId
     * @param MediaArticle $article
     * @param int $index
     * @return array
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function updateArticle($mediaId, MediaArticle $article, int $index = 0)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_UPDATE_NEWS, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'media_id' => $mediaId,
            'index'    => $index,
            'articles' => $article->toArray(null, MediaRequest::FILTER_NOT_NULL)
        ];

        $response = NetWork::postJsonForJson($url, $postData);
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }

    /**
     * 上传永久素材使用的图片
     * @param MediaRequest $mediaBean
     * @return array
     * @throws InvalidUrl
     * @throws MimeDetectorException
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function uploadArticleImage(MediaRequest $mediaBean)
    {
        $url = ApiUrl::generateURL(ApiUrl::MATERIAL_UPLOAD_NEWS_IMG, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        return $this->uploadMedia($url, $this->crateFileBean($mediaBean));
    }
}