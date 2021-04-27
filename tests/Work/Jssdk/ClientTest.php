<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 23:00
 */

namespace EasySwoole\WeChat\Tests\Work\Jssdk;


use EasySwoole\WeChat\Kernel\Cache\FileCacheDriver;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Jssdk\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetAppid()
    {
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $this->assertSame('mock_corpId', $app[ServiceProviders::Config]->get('corpId'));
    }

    public function testGetTicket()
    {
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $ticketJson = $this->readMockResponseJson('getTicket.json');
        $ticket = json_decode($ticketJson, true);

        $cacheKey = 'easyswoole_wechat_js_ticket_' . 'config_' . $app[ServiceProviders::Config]->get('corpId');

        $app->rebind(ServiceProviders::Cache, new FileCacheDriver(dirname(dirname(dirname(__DIR__))) . '/Tmp'));


        $response = $this->buildResponse(Status::CODE_OK, $ticketJson);

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/get_jsapi_ticket', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        /** @var FileCacheDriver $cache */
        $cache = $app[ServiceProviders::Cache];

        // mock no refresh and cached
        $this->assertTrue($cache->set($cacheKey, $ticket['ticket'], $ticket['expires_in'] - 500));
        $this->assertSame($ticket['ticket'], $client->getTicket(false));

        // mock no refresh and no cached
        $this->assertTrue($cache->delete($cacheKey));
        $this->assertSame($ticket['ticket'], $client->getTicket(false));

        // mock with refresh and cached
        $this->assertTrue($cache->set($cacheKey, $ticket, $ticket['expires_in'] - 500));
        $this->assertSame($ticket['ticket'], $client->getTicket());
    }

    public function testGetAgentTicket()
    {
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $ticketJson = $this->readMockResponseJson('getAgentTicket.json');
        $ticket = json_decode($ticketJson, true);

        $mockAgentId = 100023;

        $cacheKey = 'easyswoole_wechat_js_ticket_' . $mockAgentId . '_agent_config_' . $app[ServiceProviders::Config]->get('corpId');

        $app->rebind(ServiceProviders::Cache, new FileCacheDriver(dirname(dirname(dirname(__DIR__))) . '/Tmp'));

        $response = $this->buildResponse(Status::CODE_OK, $ticketJson);

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/ticket/get', $request->getUri()->getPath());
            $this->assertEquals('type=agent_config&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        /** @var FileCacheDriver $cache */
        $cache = $app[ServiceProviders::Cache];

        // mock no refresh and cached
        $this->assertTrue($cache->set($cacheKey, $ticket, $ticket['expires_in'] - 500));
        $this->assertSame($ticket, $client->getAgentTicket($mockAgentId));


        // mock no refresh and no cached
        $this->assertTrue($cache->delete($cacheKey));
        $this->assertSame($ticket, $client->getAgentTicket($mockAgentId));


        // mock with refresh and cached
        $this->assertTrue($cache->set($cacheKey, $ticket, $ticket['expires_in'] - 500));;
        $this->assertSame($ticket, $client->getAgentTicket($mockAgentId, true));
    }

    public function testBuildAgentConfig()
    {
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app->rebind(ServiceProviders::Cache, new FileCacheDriver(dirname(dirname(dirname(__DIR__))) . '/Tmp'));

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAgentTicket.json'));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
        }, $response, $app);

        $client = new Client($app);

        $config = json_decode($client->buildAgentConfig(['api1', 'api2'], 'agentId'), true);

        $this->assertArrayHasKey('debug', $config);
        $this->assertArrayHasKey('beta', $config);
        $this->assertArrayHasKey('jsApiList', $config);
        $this->assertArrayHasKey('openTagList', $config);

        $this->assertFalse($config['debug']);
        $this->assertFalse($config['beta']);
        $this->assertSame(['api1', 'api2'], $config['jsApiList']);

        // mock => beta: true, debug: true, json:false
        $config = $client->buildAgentConfig(['api1', 'api2'], 'agentId', true, true, false, ['foo', 'bar']);

        $this->assertArrayHasKey('debug', $config);
        $this->assertArrayHasKey('beta', $config);
        $this->assertArrayHasKey('jsApiList', $config);
        $this->assertArrayHasKey('openTagList', $config);

        $this->assertTrue($config['debug']);
        $this->assertTrue($config['beta']);
        $this->assertSame(['api1', 'api2'], $config['jsApiList']);
        $this->assertSame(['foo', 'bar'], $config['openTagList']);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
