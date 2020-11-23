<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\TemplateMessage;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\TemplateMessage\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testSetIndustry()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('set_industry.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/template/api_set_industry', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->setIndustry(1, 4));
    }


    public function testGetIndustry()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get_industry.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/template/get_industry', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getIndustry());
        $this->assertEquals(json_decode($this->readMockResponseJson('get_industry.json'), true), $client->getIndustry());
    }


    public function testAddTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('add_template.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/template/api_add_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->addTemplate('TM00015'));
        $this->assertEquals(json_decode($this->readMockResponseJson('add_template.json'), true), $client->addTemplate('TM00015'));
    }


    public function testGetPrivateTemplates()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get_template.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/template/get_all_private_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getPrivateTemplates());
        $this->assertEquals(json_decode($this->readMockResponseJson('get_template.json'), true), $client->getPrivateTemplates());
    }


    public function testDeletePrivateTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('delete_template.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/template/del_private_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->deletePrivateTemplate('Dyvp3-Ff0cnail_CDSzk1fIc6-9lOkxsQE7exTJbwUE'));
    }


    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send_template.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/template/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $data = array(
            'touser' => 'OPENID',
            'template_id' => 'ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY',
            'url' => 'http://weixin.qq.com/download',
            'miniprogram' =>
                array(
                    'appid' => 'xiaochengxuappid12345',
                    'pagepath' => 'index?foo=bar',
                ),
            'data' =>
                array(
                    'first' =>
                        array(
                            'value' => '恭喜你购买成功！',
                            'color' => '#173177',
                        ),
                    'keyword1' =>
                        array(
                            'value' => '巧克力',
                            'color' => '#173177',
                        ),
                    'keyword2' =>
                        array(
                            'value' => '39.8元',
                            'color' => '#173177',
                        ),
                    'keyword3' =>
                        array(
                            'value' => '2014年9月22日',
                            'color' => '#173177',
                        ),
                    'remark' =>
                        array(
                            'value' => '欢迎再次购买！',
                            'color' => '#173177',
                        ),
                ),
        );
        $this->assertIsArray($client->send($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('send_template.json'), true), $client->send($data));
    }


    public function testSendSubscription()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send_subscription.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/template/subscribe', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $data = array(
            'touser' => 'OPENID',
            'template_id' => 'TEMPLATE_ID',
            'url' => 'URL',
            'miniprogram' =>
                array(
                    'appid' => 'xiaochengxuappid12345',
                    'pagepath' => 'index?foo=bar',
                ),
            'scene' => 'SCENE',
            'title' => 'TITLE',
            'data' =>
                array(
                    'content' =>
                        array(
                            'value' => 'VALUE',
                            'color' => 'COLOR',
                        ),
                ),
        );
        $this->assertTrue($client->sendSubscription($data));
    }


    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}