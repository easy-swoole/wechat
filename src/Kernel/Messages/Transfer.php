<?php


namespace EasySwoole\WeChat\Kernel\Messages;

/**
 * Class Transfer
 * @package EasySwoole\WeChat\Kernel\Messages
 * @property string $account
 */
class Transfer extends Message
{
    protected $type = Message::TRANSFER_CUSTOMER_SERVICE;

    public function __construct(string $account = null)
    {
        parent::__construct(['account' => $account]);
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->get('account', '');
    }

    /**
     * @param string $account
     * @return $this
     */
    public function setAccount(string $account): self
    {
        $this->set('account', $account);
        return $this;
    }


    public function toXmlArray(): array
    {
        return empty($this->get('account')) ? [] : [
            'TransInfo' => [
                'KfAccount' => $this->get('account'),
            ],
        ];
    }
}
