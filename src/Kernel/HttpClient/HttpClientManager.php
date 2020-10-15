<?php


namespace EasySwoole\WeChat\Kernel\HttpClient;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use ReflectionClass;
use ReflectionException;

class HttpClientManager
{
    /** @var string  */
    protected $clientClass;

    /**
     * RequestManage constructor.
     * @param string $clientClass
     * @throws RuntimeException
     */
    public function __construct(string $clientClass)
    {
        if (!class_exists($clientClass)) {
            throw new RuntimeException("class not exists, class name: {$clientClass}");
        }

        try {
            if (!(new ReflectionClass($clientClass))->isSubclassOf(ClientInterface::class)) {
                throw new RuntimeException("invalid class, the class must implements ". ClientInterface::class);
            }
        } catch (ReflectionException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        $this->clientClass = $clientClass;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return new $this->clientClass();
    }
}