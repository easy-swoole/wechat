<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\BoardingPassClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class BoardingPassClientTest extends TestCase
{
    public function testCheckin()
    {
        $params = [
            "code" => "198374613512",
            "card_id" => "p1Pj9jr90_SQRaVqYI239Ka1erkI",
            "passenger_name" => "乘客姓名",
            "class" => "舱等",
            "seat" => "座位号",
            "etkt_bnr" => "电子客票号",
            "qrcode_data" => "二维码数据",
            "is_cancel " => false
        ];

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('checkin.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/boardingpass/checkin', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new BoardingPassClient($app);
        $this->assertTrue($client->checkin($params));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
