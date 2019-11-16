<?php


namespace EasySwoole\WeChat\OpenPlatform;


use EasySwoole\Component\Event;
use EasySwoole\WeChat\Bean\OpenPlatform\RequestConst;
use EasySwoole\WeChat\Bean\OpenPlatform\RequestMsg;

class Server extends OpenPlatformBase
{
    private $onMessage;
    private $onEvent;
    private $onException;

    public function __construct(OpenPlatform $openPlatform)
    {
        parent::__construct($openPlatform);
        $this->onEvent = new EventContainer();
        $this->onMessage = new Event();
    }

    /**
     * parserRequest
     *
     * @param string $raw
     * @return string|null
     * @throws \EasySwoole\WeChat\Exception\EncryptorError
     * @throws \EasySwoole\WeChat\Exception\Exception
     * @throws \Throwable
     */
    public function parserRequest(string $raw): ?string
    {
        libxml_disable_entity_loader(true);
        $array = (array)simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOCDATA);
        $request = $this->parserDecode(new RequestMsg($array));

        /** Ticket事件 */
        if ($request->getInfoType() === RequestConst::EVENT_VERIFY_TICKET) {
            $this->getOpenPlatform()->verifyTicket()->setTicket($request->getComponentVerifyTicket(), $request->getCreateTime());
            return 'success';
        }

        $callBack = $this->onMessage->get($request->getInfoType());
        if (!is_callable($callBack)) {
            return 'success';
        }

        try {
            call_user_func($callBack, $request, $this->getOpenPlatform());
        } catch (\Throwable $throwable) {
            if (is_callable($this->onException)) {
                call_user_func($this->onException, $request, $throwable, $this->getOpenPlatform());
            } else {
                throw $throwable;
            }
        }

        return 'success';
    }

    /*
     * 注册消息回调
     */
    public function onMessage(): Event
    {
        return $this->onMessage;
    }

    /*
     *注册事件回调
     */
    public function onEvent(): EventContainer
    {
        if (!isset($this->onEvent)) {
            $this->onEvent = new EventContainer();
        }
        return $this->onEvent;
    }

    public function onException(callable $onException): Server
    {
        $this->onException = $onException;
        return $this;
    }

    /**
     * parserDecode
     *
     * @param RequestMsg $requestMsg
     * @return RequestMsg
     * @throws \EasySwoole\WeChat\Exception\EncryptorError
     */
    private function parserDecode(RequestMsg $requestMsg): RequestMsg
    {
        $appId = $this->getOpenPlatform()->getConfig()->getComponentAppId();
        $aesKey = $this->getOpenPlatform()->getConfig()->getAesKey();

        $messageXML = Encryptor::decrypt($appId, $requestMsg->getEncrypt(), $aesKey);
        libxml_disable_entity_loader(true);
        $array = (array)simplexml_load_string($messageXML, 'SimpleXMLElement', LIBXML_NOCDATA);
        $request = new RequestMsg($array);
        $request->setAppId($requestMsg->getAppId());
        return $request;
    }
}