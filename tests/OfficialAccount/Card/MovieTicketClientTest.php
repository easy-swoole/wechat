<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\MovieTicketClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class MovieTicketClientTest extends TestCase
{
    public function testUpdateUser()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('movie_ticket_update_user.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/movieticket/updateuser', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $param = [
            "code" => "277217129962",
            "card_id" => "p1Pj9jr90_SQRaVqYI239Ka1erkI",
            "ticket_class" => "4D",
            "show_time" => 1408493192,
            "duration" => 120,
            "screening_room" => "5号影厅",
            "seat_number" => [
                "5 排14 号",
                "5排15号"
            ]
        ];

        $client = new MovieTicketClient($app);
        $this->assertTrue($client->updateUser($param));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
