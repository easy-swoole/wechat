<?php


namespace EasySwoole\WeChat\OfficialAccount\Broadcasting;


use BadMethodCallException;
use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Messages\Card;
use EasySwoole\WeChat\Kernel\Messages\Image;
use EasySwoole\WeChat\Kernel\Messages\Media;
use EasySwoole\WeChat\Kernel\Messages\Text;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use function is_array;
use function is_int;

class Client extends BaseClient
{
    public const PREVIEW_BY_OPENID = 'touser';
    public const PREVIEW_BY_NAME = 'towxname';

    /**
     * @param array $message
     * @return array
     * @throws HttpException
     */
    public function send(array $message): array
    {
        $path = isset($message['touser']) ? '/cgi-bin/message/mass/send' : '/cgi-bin/message/mass/sendall';

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
     * @param array $message
     * @return mixed
     * @throws HttpException
     */
    public function preview(array $message)
    {
        $response = $this->getClient()->setMethod("POST")
            ->setBody($this->jsonDataToStream($message))
            ->send($this->buildUrl(
                '/cgi-bin/message/mass/preview',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * @param MessageInterface $message
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendMessage(MessageInterface $message, $reception = null, $attributes = []): array
    {
        $message = (new MessageBuilder())->message($message)->with($attributes)->toAll();

        if (is_int($reception)) {
            $message->toTag($reception);
        } elseif (is_array($reception)) {
            $message->toUsers($reception);
        }

        return $this->send($message->build());
    }

    /**
     * @param MessageInterface $message
     * @param string $reception
     * @param $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewMessage(MessageInterface $message, string $reception, $method = self::PREVIEW_BY_OPENID)
    {
        $message = (new MessageBuilder())->message($message)->buildForPreview($method, $reception);

        return $this->preview($message);
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

        return $this->checkResponse($response);
    }

    /**
     * @param string $message
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendText(string $message, $reception = null, array $attributes = [])
    {
        return $this->sendMessage(new Text($message), $reception, $attributes);
    }

    /**
     * @param string $mediaId
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendNews(string $mediaId, $reception = null, array $attributes = [])
    {
        return $this->sendMessage(new Media($mediaId, Media::MPNEWS), $reception, $attributes);
    }

    /**
     * @param string $mediaId
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendVoice(string $mediaId, $reception = null, array $attributes = [])
    {
        return $this->sendMessage(new Media($mediaId, Media::VOICE), $reception, $attributes);
    }

    /**
     * @param string $mediaId
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendImage(string $mediaId, $reception = null, array $attributes = [])
    {
        return $this->sendMessage(new Image($mediaId), $reception, $attributes);
    }

    /**
     * @param string $mediaId
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendVideo(string $mediaId, $reception = null, array $attributes = [])
    {
        return $this->sendMessage(new Media($mediaId, Media::MPVIDEO), $reception, $attributes);
    }

    /**
     * @param string $cardId
     * @param null $reception
     * @param array $attributes
     * @return array
     * @throws HttpException
     * @throws RuntimeException
     */
    public function sendCard(string $cardId, $reception = null, array $attributes = [])
    {
        return $this->sendMessage(new Card($cardId), $reception, $attributes);
    }

    /**
     * @param string $message
     * @param $reception
     * @param string $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewText(string $message, $reception, $method = self::PREVIEW_BY_OPENID)
    {
        return $this->previewMessage(new Text($message), $reception, $method);
    }

    /**
     * @param string $mediaId
     * @param $reception
     * @param string $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewNews(string $mediaId, $reception, $method = self::PREVIEW_BY_OPENID)
    {
        return $this->previewMessage(new Media($mediaId, Media::MPNEWS), $reception, $method);
    }

    /**
     * @param string $mediaId
     * @param $reception
     * @param string $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewVoice(string $mediaId, $reception, $method = self::PREVIEW_BY_OPENID)
    {
        return $this->previewMessage(new Media($mediaId, Media::VOICE), $reception, $method);
    }

    /**
     * @param string $mediaId
     * @param $reception
     * @param string $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewImage(string $mediaId, $reception, $method = self::PREVIEW_BY_OPENID)
    {
        return $this->previewMessage(new Image($mediaId), $reception, $method);
    }

    /**
     * @param string $mediaId
     * @param $reception
     * @param string $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewVideo(string $mediaId, $reception, $method = self::PREVIEW_BY_OPENID)
    {
        return $this->previewMessage(new Media($mediaId, Media::MPVIDEO), $reception, $method);
    }

    /**
     * @param string $cardId
     * @param $reception
     * @param string $method
     * @return mixed
     * @throws HttpException
     * @throws RuntimeException
     */
    public function previewCard(string $cardId, $reception, $method = self::PREVIEW_BY_OPENID)
    {
        return $this->previewMessage(new Card($cardId), $reception, $method);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (strpos($method, 'ByName') > 0) {
            $method = strstr($method, 'ByName', true);

            if (method_exists($this, $method)) {
                array_push($args, self::PREVIEW_BY_NAME);

                return $this->$method(...$args);
            }
        }

        throw new BadMethodCallException(sprintf('Method %s not exists.', $method));
    }
}
