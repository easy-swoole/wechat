<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Card extends Message
{
    protected $type = Message::WXCARD;

    /**
     * Card constructor.
     * @param string $cardId
     */
    public function __construct(string $cardId)
    {
        parent::__construct(['card_id' => $cardId]);
    }
}
