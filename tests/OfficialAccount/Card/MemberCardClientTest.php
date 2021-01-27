<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\MemberCardClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class MemberCardClientTest extends TestCase
{
    public function testActivate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('member_card_activate.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/membercard/activate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MemberCardClient($app);
        $this->assertTrue($client->activate([
            "init_bonus" => 100,
            "init_bonus_record" => "旧积分同步",
            "init_balance" => 200,
            "membership_number" => "AAA00000001",
            "code" => "12312313",
            "card_id" => "xxxx_card_id",
            "background_pic_url" => "https://mmbiz.qlogo.cn/mmbiz/0?wx_fmt=jpeg",
            "init_custom_field_value1" => "xxxxx"
        ]));
    }

    public function testSetActivationForm()
    {

        $cardId = 'pbLatjnrwUUdZI641gKdTMJzHGfc';

        $settings = [
            "service_statement" => [
                "name" => "会员守则",
                "url" => "https://www.qq.com"
            ],
            "bind_old_card" => [
                "name" => "老会员绑定",
                "url" => "https://www.qq.com"
            ],
            "required_form" => [
                "can_modify" => false,
                "rich_field_list" => [
                    [
                        "type" => "FORM_FIELD_RADIO",
                        "name" => "兴趣",
                        "values" => [
                            "钢琴",
                            "舞蹈",
                            "足球"
                        ]
                    ],
                    [
                        "type" => "FORM_FIELD_SELECT",
                        "name" => "喜好",
                        "values" => [
                            "郭敬明",
                            "韩寒",
                            "南派三叔"
                        ]
                    ],
                    [
                        "type" => "FORM_FIELD_CHECK_BOX",
                        "name" => "职业",
                        "values" => [
                            "赛车手",
                            "旅行家"
                        ]
                    ]
                ],
                "common_field_id_list" => [
                    "USER_FORM_INFO_FLAG_MOBILE"
                ]
            ],
            "optional_form" => [
                "can_modify" => false,
                "common_field_id_list" => [
                    "USER_FORM_INFO_FLAG_LOCATION",
                    "USER_FORM_INFO_FLAG_BIRTHDAY"
                ],
                "custom_field_list" => [
                    "喜欢的电影"
                ]
            ]
        ];

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('member_card_set_activation_form.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/membercard/activateuserform/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MemberCardClient($app);
        $this->assertTrue($client->setActivationForm($cardId, $settings));

    }

    public function testGetUser()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('member_card_get_user.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/membercard/userinfo/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MemberCardClient($app);
        $this->assertIsArray($client->getUser('pbLatjtZ7v1BG_ZnTjbW85GYc_E8', '916679873278'));
        $this->assertEquals(json_decode($this->readMockResponseJson('member_card_get_user.json'), true), $client->getUser('pbLatjtZ7v1BG_ZnTjbW85GYc_E8', '916679873278'));
    }

    public function testUpdateUser()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('member_card_update_user.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/membercard/updateuser', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MemberCardClient($app);
        $params = [
            "code" => "179011264953",
            "card_id" => "p1Pj9jr90_SQRaVqYI239Ka1erkI",
            "background_pic_url" => "https://mmbiz.qlogo.cn/mmbiz/0?wx_fmt=jpeg",
            "record_bonus" => "消费30元，获得3积分",
            "bonus" => 3000,
            "add_bonus" => 30,
            "balance" => 3000,
            "add_balance" => -30,
            "record_balance" => "购买焦糖玛琪朵一杯，扣除金额30元。",
            "custom_field_value1" => "xxxxx",
            "custom_field_value2" => "xxxxx",
            "notify_optional" => [
                "is_notify_bonus" => true,
                "is_notify_balance" => true,
                "is_notify_custom_field1" => true
            ]
        ];
        $this->assertIsArray($client->updateUser($params));
        $this->assertEquals(json_decode($this->readMockResponseJson('member_card_update_user.json'), true), $client->updateUser($params));
    }


    public function testGetActivationForm()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('member_card_get_activation_form.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/membercard/activatetempinfo/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MemberCardClient($app);
        $this->assertIsArray($client->getActivationForm('abcdefg'));
        $this->assertEquals(json_decode($this->readMockResponseJson('member_card_get_activation_form.json'), true), $client->getActivationForm('abcdefg'));
    }

    public function testGetActivateUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('member_card_get_activate_url.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/membercard/activate/geturl', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MemberCardClient($app);
        $params = [
            "card_id" => "pbLatji6o5g7hJh8Otuvux4y1ty0",
            "outer_str" => "123"
        ];
        $this->assertIsArray($client->getActivateUrl($params));
        $this->assertEquals(json_decode($this->readMockResponseJson('member_card_get_activate_url.json'), true), $client->getActivateUrl($params));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
