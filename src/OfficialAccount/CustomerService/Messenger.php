<?php


namespace EasySwoole\WeChat\OfficialAccount\CustomerService;


use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\Kernel\Messages\Text;

class Messenger
{

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $account;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|Message $message
     * @return Messenger
     */
    public function message($message)
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $this->message = $message;

        return $this;
    }

    /**
     * @param string $account
     * @return Messenger
     */
    public function by(string $account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @param string $account
     * @return Messenger
     */
    public function from(string $account)
    {
        return $this->by($account);
    }

    /**
     * @param string $openid
     * @return Messenger
     */
    public function to(string $openid)
    {
        $this->to = $openid;

        return $this;
    }

    public function send()
    {
        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        if ($this->message instanceof Raw) {
            $message = json_decode($this->message->getContent());
        } else {
            $prepends = [
                'touser' => $this->to
            ];

            if ($this->account) {
                $prepends['customservice'] = ['kf_account' => $this->account];
            }

            $prepends['msgtype'] = $this->message->getType();
            $message = $this->message->transformForJsonRequest($prepends);
        }

        return $this->client->send($message);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }
}
