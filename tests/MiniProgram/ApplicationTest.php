<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 21:52
 */

namespace EasySwoole\WeChat\Tests\MiniProgram;


use EasySwoole\WeChat\MiniProgram\Application;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\Tests\Mock\Message\Status;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\ActivityMessage\Client::class, $app->activityMessage);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\AppCode\Client::class, $app->appCode);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Auth\AccessToken::class, $app->accessToken);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Auth\Client::class, $app->auth);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Base\Client::class, $app->base);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Broadcast\Client::class, $app->broadcast);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\CustomerService\Client::class, $app->customerService);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\DataCube\Client::class, $app->dataCube);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Express\Client::class, $app->express);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Live\Client::class, $app->live);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Mall\ForwardsMall::class, $app->mall);
        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Mall\CartClient::class, $app->mall->cart);
        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Mall\MediaClient::class, $app->mall->media);
        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Mall\OrderClient::class, $app->mall->order);
        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Mall\ProductClient::class, $app->mall->product);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\NearbyPoi\Client::class, $app->nearbyPoi);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Ocr\Client::class, $app->ocr);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\OpenData\Client::class, $app->openData);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Plugin\Client::class, $app->plugin);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Plugin\DevClient::class, $app->pluginDev);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\RealtimeLog\Client::class, $app->realtimeLog);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\RiskControl\Client::class, $app->riskControl);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Search\Client::class, $app->search);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Server\Guard::class, $app->server);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Soter\Client::class, $app->soter);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\SubscribeMessage\Client::class, $app->subscribeMessage);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\TemplateMessage\Client::class, $app->templateMessage);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\UniformMessage\Client::class, $app->uniformMessage);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Union\Client::class, $app->union);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\UrlScheme\Client::class, $app->urlScheme);
    }

    public function testMagicCall()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPaidUnionid.json'));

        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/getpaidunionid', $request->getUri()->getPath());
            $this->assertEquals('openid=mock_openid&transaction_id=mock_transaction_id&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = $app->base;

        $this->assertIsArray($client->getPaidUnionid('mock_openid', [
            'transaction_id' => 'mock_transaction_id'
        ]));

        $this->assertSame(json_decode($this->readMockResponseJson('getPaidUnionid.json'), true), $client->getPaidUnionid('mock_openid', [
            'transaction_id' => 'mock_transaction_id'
        ]));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/Base/mock_data/' . $filename);
    }
}