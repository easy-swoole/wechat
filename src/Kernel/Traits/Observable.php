<?php


namespace EasySwoole\WeChat\Kernel\Traits;


use Closure;
use EasySwoole\WeChat\Kernel\Clauses\Clause;
use EasySwoole\WeChat\Kernel\Contracts\EventHandlerInterface;
use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OfficialAccount\Server\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use Throwable;

trait Observable
{
    /** @var array */
    protected $handlers = [];
    /** @var array */
    protected $wildcardHandlers = [];
    /** @var array */
    protected $clauses = [];

    /**
     * @param $event
     * @param $payload
     * @return MessageInterface|mixed|null
     * @throws Throwable
     */
    public function notify($event, $payload)
    {
        foreach ($this->getHandlers() as $eventType => $handlers) {
            if ("*" === $eventType || $eventType === $event) {
                foreach ($handlers as $handler) {
                    if ($clause = $this->clauses[$this->getHandlerHash($handler)] ?? null) {
                        if ($clause->intercepted($payload)) {
                            continue;
                        }
                    }
                    $response = $this->callHandler($handler, $payload);

                    switch (true) {
                        case true === $response:
                        case null === $response:
                            continue 2;
                        case false === $response:
                            return null;
                        case !empty($response):
                            return $response;
                    }
                }
            }
        }
        return null;
    }

    /**
     * @param $events
     * @param $handler
     * @return Clause
     * @throws InvalidArgumentException
     */
    public function on($events, $handler)
    {
        return $this->push($events, $handler);
    }

    /**
     * @param $handler
     * @param $events
     * @return Clause
     * @throws InvalidArgumentException
     */
    public function push($handler, $events = '*')
    {
        $handler = $this->makeClosure($handler);
        if (is_array($events)) {
            foreach ($events as $event) {
                $this->addHandler($handler, $event);
            }
        } else {
            $this->addHandler($handler, $events);
        }

        return $this->newClause($handler);
    }

    /**
     * @param        $handler
     * @param string $events
     * @return Clause
     * @throws InvalidArgumentException
     */
    public function unshift($handler, $events = '*')
    {
        $handler = $this->makeClosure($handler);
        if (is_array($events)) {
            foreach ($events as $event) {
                $this->addHandler($handler, $event, true);
            }
        } else {
            $this->addHandler($handler, $events, true);
        }
        return $this->newClause($handler);
    }

    protected function addHandler($handler, $event, $unshift = false)
    {
        if ($event === '*') {
            $unshift
                ? array_unshift($this->wildcardHandlers, $handler)
                : array_push($this->wildcardHandlers, $handler);
        } else {
            if (!isset($this->handlers[$event])) {
                $this->handlers[$event] = [];
            }

            $unshift
                ? array_unshift($this->handlers[$event], $handler)
                : array_push($this->handlers[$event], $handler);
        }
    }

    protected function getHandlers(): array
    {
        $handlers = $this->handlers;
        $handlers['*'] = $this->wildcardHandlers;
        return $handlers;
    }

    /**
     * @param $handler
     * @return Clause
     */
    protected function newClause($handler): Clause
    {
        return $this->clauses[$this->getHandlerHash($handler)] = new Clause();
    }

    /**
     * @param $handler
     * @return string
     */
    protected function getHandlerHash($handler)
    {
        if (is_string($handler)) {
            return $handler;
        }

        if (is_array($handler)) {
            return is_string($handler[0])
                ? $handler[0] . '::' . $handler[1]
                : get_class($handler[0]) . $handler[1];
        }

        return spl_object_hash($handler);
    }

    /**
     * @param $handler
     * @return callable|Closure
     * @throws InvalidArgumentException
     */
    protected function makeClosure($handler)
    {
        if (is_callable($handler)) {
            return $handler;
        }

        if (is_string($handler)) {
            try {
                if (!(new ReflectionClass($handler))->isSubclassOf(EventHandlerInterface::class)) {
                    throw new InvalidArgumentException(sprintf('Class "%s" not an instance of "%s".', $handler, EventHandlerInterface::class));
                }
            } catch (ReflectionException $exception) {
                throw new InvalidArgumentException(sprintf('Class "%s" not exists.', $handler));
            }

            return function ($payload) use ($handler) {
                return (new $handler($this->app ?? null))->handle($payload);
            };
        }

        if ($handler instanceof EventHandlerInterface) {
            return function (...$args) use ($handler) {
                return $handler->handle(...$args);
            };
        }

        throw new InvalidArgumentException('No valid handler is found in arguments.');
    }

    /**
     * @param $handler
     * @param $payload
     * @return mixed
     * @throws Throwable
     */
    protected function callHandler($handler, $payload)
    {
        try {
            return call_user_func($handler, $payload);
        } catch (Throwable $e) {
            if (property_exists($this, "app") && $this->app instanceof ServiceProvider) {
                $this->app[ServiceProviders::Logger]->error(
                    $e->getCode() . ": " . $e->getMessage(),
                    [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ]
                );
                return null;
            } else {
                throw $e;
            }
        }
    }
}
