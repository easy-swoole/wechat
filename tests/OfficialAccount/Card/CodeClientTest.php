<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\CodeClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class CodeClientTest extends TestCase
{
    public function testDeposit()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/deposit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertTrue($client->deposit('ph_gmt7cUVrlRk8swPwx7aDyF-pg', ['111', '222']));
    }

    public function testGetDepositedCount()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/getdepositcount', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertIsArray($client->getDepositedCount('ph_gmt7cUVrlRk8swPwx7aDyF-pg'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->getDepositedCount('ph_gmt7cUVrlRk8swPwx7aDyF-pg'));
    }


    public function testCheck()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/checkcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertIsArray($client->check('ph_gmt7cUVrlRk8swPwx7aDyF-pg', ['111', '222']));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->check('ph_gmt7cUVrlRk8swPwx7aDyF-pg', ['111', '222']));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertIsArray($client->get('123456789', 'ph_gmt7cUVrlRk8swPwx7aDyF-pg'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->get('123456789', 'ph_gmt7cUVrlRk8swPwx7aDyF-pg'));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertTrue($client->update('123456789', '3495739475-pg'));
    }


    public function testDisable()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/unavailable', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertTrue($client->disable('123456789', 'pFS7Fjg8kV1IdDz01r4SQwMkuCKc'));
    }


    public function testConsume()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/consume', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertIsArray($client->consume('123456789', 'pFS7Fjg8kV1IdDz01r4SQwMkuCKc'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->consume('123456789', 'pFS7Fjg8kV1IdDz01r4SQwMkuCKc'));
    }


    public function testDecrypt()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/code/decrypt', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CodeClient($app);
        $this->assertIsArray($client->decrypt('XXIzTtMqCxwOaawoE91+VJdsFmv7b8g0VZIZkqf4GWA60Fzpc8ksZ/5ZZ0DVkXdE'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->decrypt('XXIzTtMqCxwOaawoE91+VJdsFmv7b8g0VZIZkqf4GWA60Fzpc8ksZ/5ZZ0DVkXdE'));
    }

    protected function readMockResponseJsonByFunction(string $func, bool $jsonDecode = false)
    {
        $fileName = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', ltrim($func, 'test'))) . '.json';
        $ret = file_get_contents(dirname(__FILE__) . '/mock_data/code_' . $fileName);
        return $jsonDecode ? json_decode($ret, true) : $ret;
    }
}
