<?php


namespace EasySwoole\WeChat\Kernel\Traits;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;

trait HasAttributes
{
    protected $attributes = [];


    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function all(): array
    {
        $this->checkRequiredAttributes();

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

    /**
     * @return array|mixed|null
     */
    public function getRequired()
    {
        return property_exists($this, 'required') ? $this->required : [];
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function checkRequiredAttributes()
    {
        foreach ($this->getRequired() as $attribute) {
            if (is_null($this->get($attribute))) {
                throw new InvalidArgumentException(sprintf('"%s" cannot be empty.', $attribute));
            }
        }
    }
}