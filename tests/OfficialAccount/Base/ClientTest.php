<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Base;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Base\Client;
use EasySwoole\WeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testClearQuota()
    {
        $response = $this->buildResponse(200, '{ "errcode" :0, "errmsg" : "ok" }');
        $app = $this->mockAccessToken(new ServiceContainer());
        $app = $this->mockHttpClient($response, $app);

        $client = new Client($app);
        $this->assertTrue($client->clearQuota());
    }
}