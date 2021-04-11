<?php

namespace EasySwoole\WeChat\Work\User;

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
}