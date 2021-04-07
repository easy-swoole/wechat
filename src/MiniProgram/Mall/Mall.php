<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\MiniProgram\Application;

/**
 * Class Mall
 * @package EasySwoole\WeChat\MiniProgram\Mall
 * @property OrderClient $mallOrder
 * @property CartClient $mallCart
 * @property ProductClient $mallProduct
 * @property MediaClient $mallMedia
 */
class Mall extends Client
{
    const MallOrder = 'mallOrder';
    const MallCart = 'mallCart';
    const MallProduct = 'mallProduct';
    const MallMedia = 'mallMedia';

    public function __get($property)
    {
        $key = Application::Mall . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No MallClient named "%s".', $property));
    }
}