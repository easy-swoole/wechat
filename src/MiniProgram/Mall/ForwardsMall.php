<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;

/**
 * Class ForwardsMall
 * @package EasySwoole\WeChat\MiniProgram\Mall
 * @author: XueSi
 * @email: <1592328848@qq.com>
 *
 * @property OrderClient $order
 * @property CartClient $cart
 * @property ProductClient $product
 * @property MediaClient $media
 */
class ForwardsMall
{
    const MallOrder = 'mallOrder';
    const MallCart = 'mallCart';
    const MallProduct = 'mallProduct';
    const MallMedia = 'mallMedia';

    /**
     * @var Container
     */
    protected $app;

    /**
     * @param Container $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param string $property
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function __get(string $property)
    {
        $key = Application::Mall . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No mall service named "%s".', $property));
    }
}
