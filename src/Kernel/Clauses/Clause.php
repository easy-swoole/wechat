<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasySwoole\WeChat\Kernel\Clauses;

/**
 * Class Clause.
 * @see https://github.com/overtrue/wechat/pull/1315
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Clause
{
    /**
     * @var array
     */
    protected $clauses = [
        'where' => [],
    ];

    /**
     * @param mixed ...$args
     *
     * @return $this
     */
    public function where(...$args)
    {
        array_push($this->clauses['where'], $args);

        return $this;
    }

    /**
     * @param mixed $payload
     *
     * @return bool
     */
    public function intercepted($payload): bool
    {
        return $this->interceptWhereClause($payload);
    }

    /**
     * @param mixed $payload
     *
     * @return bool
     */
    protected function interceptWhereClause($payload): bool
    {
        foreach ($this->clauses['where'] as $item) {
            list($key, $value) = $item;
            if (isset($payload[$key]) && $payload[$key] !== $value) {
                return true;
            }
        }
        return false;
    }
}