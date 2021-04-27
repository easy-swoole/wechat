<?php

namespace EasySwoole\WeChat\Work\User;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;

/**
 * Class User
 * @package EasySwoole\WeChat\Work\User
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * @property TagClient $tag
 * @property LinkedCorpClient $linkedCorp
 * @property BatchJobsClient $batchJobs
 */
class User extends Client
{
    const Tag = 'Tag';
    const LinkedCorp = 'LinkedCorp';
    const BatchJobs = 'BatchJobs';

    public function __get($property)
    {
        $key = ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No externalContact service named "%s".', $property));
    }
}
