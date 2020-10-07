<?php


namespace EasySwoole\WeChat\Kernel;


use EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    public function __construct(array $data = null)
    {
        parent::__construct($data, true);
    }

    /**
     * @param string|null $path
     * @param mixed|null        $default
     * @return mixed
     */
    public function get(string $path = null, $default = null)
    {
        $array = $this->jsonSerialize();

        if (is_null($path)) {
            return $array;
        }

        foreach (explode('.', $path) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }
}