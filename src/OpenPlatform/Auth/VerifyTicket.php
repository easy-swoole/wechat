<?php

namespace EasySwoole\WeChat\OpenPlatform\Auth;

use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;

class VerifyTicket
{
    protected $app;

    /**
     * VerifyTicket constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $ticket
     * @param int $ttl
     * @return $this
     */
    public function setTicket(string $ticket, int $ttl = 3600): self
    {
        $this->app[ServiceProviders::Cache]->set($this->getCacheKey(), $ticket, $ttl);
        if (!$this->app[ServiceProviders::Cache]->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache verify ticket.');
        }

        return $this;
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function getTicket(): string
    {
        $ticket = $this->app[ServiceProviders::Cache]->get($this->getCacheKey());
        if (empty($ticket)) {
            throw new RuntimeException('Credential "component_verify_ticket" does not exist in cache.');
        }
        return $ticket;
    }

    /**
     * @return string
     */
    protected function getCacheKey(): string
    {
        return 'easyswoole_wechat_verify_ticket_'. $this->app[ServiceProviders::Config]->get('appId');
    }
}
