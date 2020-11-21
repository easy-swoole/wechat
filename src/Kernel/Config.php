<?php


namespace EasySwoole\WeChat\Kernel;



use EasySwoole\WeChat\Kernel\Traits\HasAttributes;

class Config
{
    use HasAttributes;

    public function __construct(array $data = [])
    {
        $this->setAttributes($data);
    }

    /**
     * @param string|null $path
     * @param mixed|null        $default
     * @return mixed
     */
    public function get(string $path = null, $default = null)
    {
        $array = $this->all();

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