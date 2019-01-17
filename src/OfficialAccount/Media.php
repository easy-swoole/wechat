<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 18-12-30
 * Time: 下午9:43
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\Utility\MimeType;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaResponse;
use EasySwoole\WeChat\Bean\OfficialAccount\PostFile;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\HttpClient;
use Swoole\Coroutine;

/**
 * Class Media
 *
 * @package EasySwoole\WeChat\OfficialAccount
 */
class Media extends OfficialAccountBase
{
    /**
     * @param MediaRequest $mediaBean
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function upload(MediaRequest $mediaBean)
    {
        $url = ApiUrl::generateURL(ApiUrl::MEDIA_UPLOAD, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken(),
            'TYPE' => $mediaBean->getType()
        ]);

        return $this->uploadMedia($url, $this->crateFileBean($mediaBean));
    }

    /**
     * @param $mediaId
     * @return MediaResponse || array
     * @throws OfficialAccountError
     */
    public function get($mediaId)
    {
        $url = ApiUrl::generateURL(ApiUrl::MEDIA_GET, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken(),
            'MEDIA_ID' => $mediaId
        ]);

        return $this->getMedia($url);
    }

    /**
     * @param string     $url
     * @param PostFile   $fileBean
     * @param array|null $form
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    protected function uploadMedia(string $url, PostFile $fileBean, array $form = null) : array
    {
        $postData = Array();
        array_push($postData, [$fileBean->getData(), $fileBean->getName(), $fileBean->getMimeType(), $fileBean->getFilename()]);
        if (!is_null($form)) {
            foreach ($form as $name => $content) {
                if (version_compare(phpversion('swoole'), '4.2.12', '<')) {
                    array_push($postData, [$name, $content, null, null]);
                } else {
                    array_push($postData, [$name, $content]);
                }
            }
        }

        $responseArray = HttpClient::postForJson($url, $postData, 30);
        $ex = OfficialAccountError::hasException($responseArray);
        if($ex){
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * @param string $url
     * @param array  $data
     * @return MediaResponse|mixed
     * @throws OfficialAccountError
     */
    protected function getMedia(string $url, array $data = null)
    {
        if (!is_null($data)) {
            $response = HttpClient::postJson($url, $data);
        } else {
            $response = HttpClient::get($url);
        }

        $response = new MediaResponse($response);
        if ($response->isJson()) {
            // if an exception is found, it is thrown
            $this->hasException(json_decode($response->getContent(), true));
        }
        return $response;
    }

    /**
     * @param MediaRequest $mediaBean
     * @return PostFile
     */
    protected function crateFileBean(MediaRequest $mediaBean) : PostFile
    {
        $fileBean = new PostFile($mediaBean->toArray(null, MediaRequest::FILTER_NOT_EMPTY));
        $fileBean->setName('media');

        if (!is_null($fileBean->getPath())) {
            $fileBean->setData(Coroutine::readFile($fileBean->getPath()));
        }
        $fileBean->setMimeType(MimeType::getMimeTypeFromStream($fileBean->getData()));
        $fileBean->setFilename($fileBean->getName(). MimeType::getExtByMimeType($fileBean->getMimeType()));

        return $fileBean;
    }
}