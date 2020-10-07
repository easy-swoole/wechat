<?php


namespace EasySwoole\WeChat\OfficialAccount\Server;


use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\ServerGuard;
use Psr\Http\Message\ServerRequestInterface;

class Guard extends ServerGuard
{
    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    protected function isValidateRequest(ServerRequestInterface $request): bool
    {
        return isset($request->getQueryParams()['echostr']);
    }

    /**
     * @param array $message
     * @return MessageInterface
     */
    protected function buildRequestMessage(array $message): MessageInterface
    {
        return new class ($message) extends Message {
            protected $Content;
            protected $Title;
            protected $Description;
            protected $Url;
            protected $Location_X;
            protected $Location_Y;
            protected $Scale;
            protected $Label;
            protected $MediaId;
            protected $ThumbMediaId;
            protected $Format;
            protected $Recognition;

            /**
             * @return mixed
             */
            public function getContent()
            {
                return $this->Content;
            }

            /**
             * @param mixed $Content
             */
            public function setContent($Content): void
            {
                $this->Content = $Content;
            }

            /**
             * @return mixed
             */
            public function getTitle()
            {
                return $this->Title;
            }

            /**
             * @param mixed $Title
             */
            public function setTitle($Title): void
            {
                $this->Title = $Title;
            }

            /**
             * @return mixed
             */
            public function getDescription()
            {
                return $this->Description;
            }

            /**
             * @param mixed $Description
             */
            public function setDescription($Description): void
            {
                $this->Description = $Description;
            }

            /**
             * @return mixed
             */
            public function getUrl()
            {
                return $this->Url;
            }

            /**
             * @param mixed $Url
             */
            public function setUrl($Url): void
            {
                $this->Url = $Url;
            }

            /**
             * @return mixed
             */
            public function getLocationX()
            {
                return $this->Location_X;
            }

            /**
             * @param mixed $Location_X
             */
            public function setLocationX($Location_X): void
            {
                $this->Location_X = $Location_X;
            }

            /**
             * @return mixed
             */
            public function getLocationY()
            {
                return $this->Location_Y;
            }

            /**
             * @param mixed $Location_Y
             */
            public function setLocationY($Location_Y): void
            {
                $this->Location_Y = $Location_Y;
            }

            /**
             * @return mixed
             */
            public function getScale()
            {
                return $this->Scale;
            }

            /**
             * @param mixed $Scale
             */
            public function setScale($Scale): void
            {
                $this->Scale = $Scale;
            }

            /**
             * @return mixed
             */
            public function getLabel()
            {
                return $this->Label;
            }

            /**
             * @param mixed $Label
             */
            public function setLabel($Label): void
            {
                $this->Label = $Label;
            }

            /**
             * @return mixed
             */
            public function getMediaId()
            {
                return $this->MediaId;
            }

            /**
             * @param mixed $MediaId
             */
            public function setMediaId($MediaId): void
            {
                $this->MediaId = $MediaId;
            }

            /**
             * @return mixed
             */
            public function getThumbMediaId()
            {
                return $this->ThumbMediaId;
            }

            /**
             * @param mixed $ThumbMediaId
             */
            public function setThumbMediaId($ThumbMediaId): void
            {
                $this->ThumbMediaId = $ThumbMediaId;
            }

            /**
             * @return mixed
             */
            public function getFormat()
            {
                return $this->Format;
            }

            /**
             * @param mixed $Format
             */
            public function setFormat($Format): void
            {
                $this->Format = $Format;
            }

            /**
             * @return mixed
             */
            public function getRecognition()
            {
                return $this->Recognition;
            }

            /**
             * @param mixed $Recognition
             */
            public function setRecognition($Recognition): void
            {
                $this->Recognition = $Recognition;
            }
        };
    }
}