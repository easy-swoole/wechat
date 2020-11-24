<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Factory;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\DeviceClient;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\GroupClient;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\MaterialClient;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\PageClient;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\RelationClient;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\StatsClient;
use EasySwoole\WeChat\Tests\TestCase;


class ShakeAroundTest extends TestCase
{
    public function testDeviceClient()
    {
        $this->assertInstanceOf(DeviceClient::class, Factory::officialAccount()->shakeAround->device);
    }

    public function testGroupClient()
    {
        $this->assertInstanceOf(GroupClient::class, Factory::officialAccount()->shakeAround->group);
    }

    public function testMaterialClient()
    {
        $this->assertInstanceOf(MaterialClient::class, Factory::officialAccount()->shakeAround->material);
    }

    public function testPageClient()
    {
        $this->assertInstanceOf(PageClient::class, Factory::officialAccount()->shakeAround->page);
    }

    public function testRelationClient()
    {
        $this->assertInstanceOf(RelationClient::class, Factory::officialAccount()->shakeAround->relation);
    }

    public function testStatsClient()
    {
        $this->assertInstanceOf(StatsClient::class, Factory::officialAccount()->shakeAround->stats);
    }
}