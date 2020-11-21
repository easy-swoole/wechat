<?php


namespace EasySwoole\WeChat\Kernel\Traits;


trait HasAttributes
{
    protected $attributes = [];


    /**
     * @return array
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes = []): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $attribute
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute(string $attribute, $default = null)
    {
        return $this->attributes[$attribute] ?? $default;
    }

    /**
     * @param string $attribute
     * @param $value
     * @return $this
     */
    public function setAttribute(string $attribute, $value):self
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    /**
     * @param string $attribute
     * @param null $default
     * @return mixed|null
     */
    public function get(string $attribute, $default = null)
    {
        return $this->getAttribute($attribute, $default);
    }

    /**
     * @param string $attribute
     * @param $value
     * @return HasAttributes
     */
    public function set(string $attribute, $value)
    {
        return $this->setAttribute($attribute, $value);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @return HasAttributes
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }
}