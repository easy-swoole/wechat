<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/25
 * Time: 23:16
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\Menu;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Menu\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    /**
     * click和view的请求示例
     * */
    function testCreate1()
    {
        $requestDataName = 'request/create1.json';
        $data = $this->readJsonToArray($requestDataName);
        $responseDataName = 'create.json';
        $method = 'POST';
        $urlFormat = '/cgi-bin/menu/create';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->create($data);
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 其他新增按钮类型的请求示例
     * */
    function testCreate2()
    {
        $requestDataName = 'request/create2.json';
        $data = $this->readJsonToArray($requestDataName);
        $responseDataName = 'create.json';
        $method = 'POST';
        $urlFormat = '/cgi-bin/menu/create';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->create($data);
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 查询接口 : 如果公众号是在公众平台官网通过网站功能发布菜单
     * */
    function testQueryConfig1()
    {
        $responseDataName = 'queryConfig1.json';
        $method = 'GET';
        $urlFormat = '/cgi-bin/get_current_selfmenu_info';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->queryConfig();
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 查询接口 : 如果公众号是通过API调用设置的菜单
     * */
    function testQueryConfig2()
    {
        $responseDataName = 'queryConfig2.json';
        $method = 'GET';
        $urlFormat = '/cgi-bin/get_current_selfmenu_info';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->queryConfig();
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 查询接口 : 如果公众号是通过API调用设置的菜单
     * */
    function testDelete()
    {
        $responseDataName = 'delete.json';
        $method = 'GET';
        $urlFormat = '/cgi-bin/menu/delete';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->delete();
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 个性化菜单接口: 创建个性化菜单
     * */
    function testAddconditional()
    {
        $requestDataName = 'request/addconditional.json';
        $data = $this->readJsonToArray($requestDataName);
        $responseDataName = 'addconditional.json';
        $method = 'POST';
        $urlFormat = '/cgi-bin/menu/addconditional';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->addconditional($data);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 个性化菜单接口: 删除个性化菜单
     * */
    function testDelconditional()
    {
        $menuId = '208379533';
        $responseDataName = 'delconditional.json';
        $method = 'POST';
        $urlFormat = '/cgi-bin/menu/delconditional';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->delconditional($menuId);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 个性化菜单接口: 测试个性化菜单匹配结果
     * */
    function testMatch()
    {
        $userId = 'weixin';
        $responseDataName = 'match.json';
        $method = 'POST';
        $urlFormat = '/cgi-bin/menu/trymatch';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->match($userId);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 获取自定义菜单配置,(无个性化菜单时)
     * */
    function testQuery1()
    {
        $responseDataName = 'query1.json';
        $method = 'GET';
        $urlFormat = '/cgi-bin/menu/get';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->query();
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 获取自定义菜单配置,(无个性化菜单时)
     * */
    function testQuery2()
    {
        $responseDataName = 'query2.json';
        $method = 'GET';
        $urlFormat = '/cgi-bin/menu/get';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat);

        $client = new Client($app);
        $rs = $client->query();
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    protected function prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat)
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson($responseDataName));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) use ($method, $urlFormat) {
            $this->assertEquals($method, $request->getMethod());
            $this->assertEquals($urlFormat, $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        return $app;
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }

    protected function readJsonToArray(string $file): array
    {
        $json = $this->readMockResponseJson($file);
        return json_decode($json, true);
    }
}