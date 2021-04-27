<?php
/**
 * User: XueSi
 * Date: 2021/4/26 14:39
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work;

use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Application;

class ApplicationTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'agentId' => 'mock_agentId',
        ]);

        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Auth\AccessToken::class, $app->accessToken);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Agent\Client::class, $app->agent);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Agent\WorkbenchClient::class, $app->agentWorkbench);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Base\Client::class, $app->base);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Calendar\Client::class, $app->calendar);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Chat\Client::class, $app->chat);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\CorpGroup\Client::class, $app->corpGroup);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Department\Client::class, $app->department);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\Client::class, $app->externalContact);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\ContactWayClient::class, $app->externalContact->contactWay);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\StatisticsClient::class, $app->externalContact->statistics);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\MessageClient::class, $app->externalContact->message);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\SchoolClient::class, $app->externalContact->school);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\MomentClient::class, $app->externalContact->moment);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\ExternalContact\MessageTemplateClient::class, $app->externalContact->messageTemplate);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Invoice\Client::class, $app->invoice);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Jssdk\Client::class, $app->jssdk);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Live\Client::class, $app->live);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Media\Client::class, $app->media);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Menu\Client::class, $app->menu);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Message\Client::class, $app->message);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Message\Messenger::class, $app->messenger);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Mobile\Auth\Client::class, $app->mobile);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\MsgAudit\Client::class, $app->msgAudit);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\OA\Client::class, $app->oa);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\OAuth\Client::class, $app->oauth);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\QrConnect\Client::class, $app->qrConnect);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Schedule\Client::class, $app->schedule);
        $this->assertInstanceOf(\EasySwoole\WeChat\Kernel\Encryptor::class, $app->encryptor);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Server\Guard::class, $app->server);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\User\Client::class, $app->user);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\User\TagClient::class, $app->user->tag);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\User\LinkedCorpClient::class, $app->user->linkedCorp);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\User\BatchJobsClient::class, $app->user->batchJobs);
    }
}
