<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\OfficialAccount\Application;

/**
 * Class Card
 * @package EasySwoole\WeChat\OfficialAccount\Card
 * @property BoardingPassClient $boardingPass
 */
class Card extends Client
{
    const BoardingPass = 'cardBoardingPass';

    public function __get($property)
    {
        $key = Application::Card . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No card service named "%s".', $property));
    }
}