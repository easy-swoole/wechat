<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 18-12-30
 * Time: 下午9:43
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\WeChat\Bean\OfficialAccount\MediaRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaResponse;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\HttpClient;
use EasySwoole\WeChat\Utility\PostFile;

/**
 * Class Media
 *
 * @package EasySwoole\WeChat\OfficialAccount
 */
class Media extends OfficialAccountBase
{
    /**
     * @param MediaRequest $mediaBean
     * @return mixed
     * @throws OfficialAccountError
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
     */
    protected function uploadMedia(string $url, PostFile $fileBean, array $form = null) : array
    {
        $responseArray = HttpClient::postFileForJson($url, $fileBean, $form);
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

        if (empty($response->getBody()) || '{' === $response->getBody()[0]) {
            $body = json_decode($response->getBody(), true);
            $ex = OfficialAccountError::hasException($body);
            if ($ex) {
                throw $ex;
            }
            return $body;
        }
        return new MediaResponse($response);
    }

    /**
     * @param MediaRequest $mediaBean
     * @return PostFile
     */
    protected function crateFileBean(MediaRequest $mediaBean) : PostFile
    {
        $fileBean = new PostFile($mediaBean->toArray(null, MediaRequest::FILTER_NOT_EMPTY));
        $fileBean->setName('media');

        if ($fileBean->getData() !== null) {
            $fileBean->setFilename($fileBean->getName(). File::getStreamExt($fileBean->getData()));
            $fileBean->setMimeType(File::getStreamMimeType($fileBean->getData()));
        }

        return $fileBean;
    }
}