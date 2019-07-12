<?php


namespace EasySwoole\WeChat\Bean\MiniProgram;

use EasySwoole\Spl\SplBean;

class BindAccount extends SplBean
{
    /** @var string */
    protected $type;
    /** @var string */
    protected $bizId;
    /** @var string */
    protected $deliveryId;
    /** @var string */
    protected $password;
    /** @var string */
    protected $remarkContent;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getBizId(): string
    {
        return $this->bizId;
    }

    /**
     * @param string $bizId
     */
    public function setBizId(string $bizId): void
    {
        $this->bizId = $bizId;
    }

    /**
     * @return string
     */
    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    /**
     * @param string $deliveryId
     */
    public function setDeliveryId(string $deliveryId): void
    {
        $this->deliveryId = $deliveryId;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRemarkContent(): string
    {
        return $this->remarkContent;
    }

    /**
     * @param string $remarkContent
     */
    public function setRemarkContent(string $remarkContent): void
    {
        $this->remarkContent = $remarkContent;
    }


}