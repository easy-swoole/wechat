<?php


namespace EasySwoole\WeChat\Work;


use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\Work
 * @property Agent\Client $agent
 * @property Agent\WorkbenchClient $agentWorkbench
 * @property Auth\AccessToken $accessToken
 * @property Base\Client $base
 * @property Calendar\Client $calendar
 * @property Chat\Client $chat
 * @property CorpGroup\Client $corpGroup
 * @property Department\Client $department
 * @property ExternalContact\ExternalContact $externalContact
 * @property GroupRobot\Client $groupRobot
 * @property GroupRobot\Messenger $groupRobotMessenger
 * @property Invoice\Client $invoice
 * @property Jssdk\Client $jssdk
 * @property Live\Client $live
 * @property Media\Client $media
 * @property Menu\Client $menu
 * @property Message\Client $message
 * @property Message\Messenger $messenger
 * @property Mobile\Auth\Client $mobile
 * @property MsgAudit\Client $msgAudit
 * @property OA\Client $oa
 * @property OAuth\Client $oauth
 * @property QrConnect\Client $qrConnect
 * @property Schedule\Client $schedule
 * @property \EasySwoole\WeChat\Kernel\Encryptor $encryptor
 * @property Server\Guard $server
 * @property User\User $user
 */
class Application extends ServiceContainer
{
    const Agent = 'agent';
    const AgentWorkbench = 'agentWorkbench';
    const Base = 'base';
    const Calendar = 'calendar';
    const Chat = 'chat';
    const CorpGroup = 'corpGroup';
    const Department = 'department';
    const ExternalContact = 'externalContact';
    const GroupRobot = 'groupRobot';
    const GroupRobotMessenger = 'groupRobotMessenger';
    const Invoice = 'invoice';
    const Jssdk = 'jssdk';
    const Live = 'live';
    const Media = 'media';
    const Menu = 'menu';
    const Message = 'message';
    const Messenger = 'messenger';
    const Mobile = 'mobile';
    const MsgAudit = 'msgAudit';
    const OA = 'oa';
    const OAuth = 'oauth';
    const QrConnect = 'qrConnect';
    const Schedule = 'schedule';
    const Server = 'server';
    const User = 'user';

    /**
     * @var string[]
     */
    protected $providers = [
        Agent\ServiceProvider::class,
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Calendar\ServiceProvider::class,
        Chat\ServiceProvider::class,
        CorpGroup\ServiceProvider::class,
        Department\ServiceProvider::class,
        ExternalContact\ServiceProvider::class,
        GroupRobot\ServiceProvider::class,
        Invoice\ServiceProvider::class,
        Jssdk\ServiceProvider::class,
        Live\ServiceProvider::class,
        Media\ServiceProvider::class,
        Menu\ServiceProvider::class,
        Message\ServiceProvider::class,
        Menu\ServiceProvider::class,
        Mobile\ServiceProvider::class,
        MsgAudit\ServiceProvider::class,
        OA\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        QrConnect\ServiceProvider::class,
        Schedule\ServiceProvider::class,
        Server\ServiceProvider::class,
        User\ServiceProvider::class,
    ];
}
