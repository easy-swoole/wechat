<?php

namespace EasySwoole\WeChat\Work\GroupRobot;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\Messages\Text;

/**
 * Class Messenger
 * @package EasySwoole\WeChat\Work\GroupRobot
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Messenger
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Message|null
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $groupKey;

    /**
     * Messenger constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $message
     * @return $this
     * @throws InvalidArgumentException
     */
    public function message($message)
    {
        if (is_string($message) || is_numeric($message)) {
            $message = new Text($message);
        }

        if (!($message instanceof Message)) {
            throw new InvalidArgumentException('Invalid message.');
        }

        $this->message = $message;

        return $this;
    }

    /**
     * @param string $groupKey
     * @return $this
     */
    public function toGroup(string $groupKey)
    {
        $this->groupKey = $groupKey;

        return $this;
    }

    /**
     * @param null $message
     * @return mixed
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function send($message = null)
    {
        if ($message) {
            $this->message($message);
        }

        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        if (is_null($this->groupKey)) {
            throw new RuntimeException('No group key specified.');
        }

        $message = $this->message->transformForJsonRequest();

        return $this->client->send($this->groupKey, $message);
    }

    /**
     * @param $property
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new InvalidArgumentException(sprintf('No property named "%s"', $property));
    }
}
