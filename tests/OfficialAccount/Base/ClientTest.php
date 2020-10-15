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


    public function testGetValidIps()
    {
        $body = '{"ip_list":["127.0.0.1","127.0.0.2","101.226.103.0/25"]}';
        $response = $this->buildResponse(200, $body);
        $app = $this->mockAccessToken(new ServiceContainer());
        $app = $this->mockHttpClient($response, $app);

        $client = new Client($app);
        $this->assertEqualsCanonicalizing(
            json_decode($body, true),
            $client->getValidIps()
        );
    }
}