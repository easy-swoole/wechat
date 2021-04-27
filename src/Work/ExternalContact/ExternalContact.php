<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Work\Application;

/**
 * Class ExternalContact
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * @property ContactWayClient $contactWay
 * @property StatisticsClient $statistics
 * @property MessageClient $message
 * @property SchoolClient $school
 * @property MomentClient $moment
 * @property MessageTemplateClient $messageTemplate
 */
class ExternalContact extends Client
{
    const ContactWay = 'externalContactContactWay';
    const ExternalContactStatistics = 'externalContactStatistics';
    const ExternalContactMessage = 'externalContactMessage';
    const School = 'externalContactSchool';
    const ExternalContactMoment = 'externalContactMoment';
    const ExternalContactMessageTemplate = 'externalContactMessageTemplate';

    public function __get($property)
    {
        $key = Application::ExternalContact . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No externalContact service named "%s".', $property));
    }

}
