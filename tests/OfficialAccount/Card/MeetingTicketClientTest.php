<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\MeetingTicketClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;


class MeetingTicketClientTest extends TestCase
{
    public function testUpdateUser()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/meetingticket/updateuser', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = [
            "code" => "717523732898",
            "card_id" => "pXch-jvdwkJjY7evUFV-sGsoMl7A",
            "zone" => "C区",
            "entrance" => "东北门",
            "seat_number" => "2排15号"
        ];

        $client = new MeetingTicketClient($app);
        $this->assertTrue($client->updateUser($params));
    }

    protected function readMockResponseJsonByFunction(string $func, bool $jsonDecode = false)
    {
        $fileName = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', ltrim($func, 'test'))) . '.json';
        $ret = file_get_contents(dirname(__FILE__) . '/mock_data/meeting_ticket_' . $fileName);
        return $jsonDecode ? json_decode($ret, true) : $ret;
    }
}