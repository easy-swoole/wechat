<?php

namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\OfficialAccount\Application;

/**
 * Class ShakeAround
 * @package EasySwoole\WeChat\OfficialAccount\ShakeAround
 * @property DeviceClient $device
 * @property GroupClient $group
 * @property MaterialClient $material
 * @property PageClient $page
 * @property RelationClient $relation
 * @property StatsClient $stats
 */
class ShakeAround extends Client
{
    const Device = 'shakeAroundDevice';
    const Group = 'shakeAroundGroup';
    const Material = 'shakeAroundMaterial';
    const Page = 'shakeAroundPage';
    const Relation = 'shakeAroundRelation';
    const Stats = 'shakeAroundStats';

    public function __get($property)
    {
        $key = Application::ShakeAround . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No shake_around service named "%s".', $property));
    }
}