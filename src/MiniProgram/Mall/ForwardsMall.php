<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;

use EasySwoole\WeChat\MiniProgram\Application;

/**
 * Class ForwardsMall
 * @package EasySwoole\WeChat\MiniProgram\Mall
 * @author: XueSi
 * @email: <1592328848@qq.com>
 *
 * @property \EasySwoole\WeChat\MiniProgram\Mall\OrderClient
 * @property \EasySwoole\WeChat\MiniProgram\Mall\CartClient
 * @property \EasySwoole\WeChat\MiniProgram\Mall\ProductClient
 * @property \EasySwoole\WeChat\MiniProgram\Mall\MediaClient
 */
class ForwardsMall
{
    const MallOrder = 'mallOrder';
    const MallCart = 'mallCart';
    const MallProduct = 'mallProduct';
    const MallMedia = 'mallMedia';

    /**
     * @var \EasySwoole\WeChat\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @param \EasySwoole\WeChat\Kernel\ServiceContainer $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        $key = Application::Mall . ucfirst($property);
        return $this->app[$key];
    }
}