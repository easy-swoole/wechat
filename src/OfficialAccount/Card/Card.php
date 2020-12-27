<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\OfficialAccount\Application;

/**
 * Class Card
 * @package EasySwoole\WeChat\OfficialAccount\Card
 * @property BoardingPassClient $boardingPass
 * @property CodeClient $code
 * @property GiftCardClient $giftCard
 * @property GiftCardOrderClient $giftCardOrder
 */
class Card extends Client
{
    const BoardingPass = 'cardBoardingPass';
    const Code = 'cardCode';
    const GiftCard = 'cardGiftCard';
    const GiftCardOrder = 'cardGiftCardOrder';

    public function __get($property)
    {
        $key = Application::Card . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No card service named "%s".', $property));
    }
}