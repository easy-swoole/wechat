<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:17
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class TemplateMsg extends SplBean
{
    protected $touser;
    protected $template_id;
    protected $url;
    protected $miniprogram;
    protected $appid;
    protected $pagepath;
    protected $data = [];
    protected $color;

    /**
     * @return mixed
     */
    public function getTouser()
    {
        return $this->touser;
    }

    /**
     * @param mixed $touser
     */
    public function setTouser($touser): void
    {
        $this->touser = $touser;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed $template_id
     */
    public function setTemplateId($template_id): void
    {
        $this->template_id = $template_id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getMiniprogram()
    {
        return $this->miniprogram;
    }

    /**
     * @param mixed $miniprogram
     */
    public function setMiniprogram($miniprogram): void
    {
        $this->miniprogram = $miniprogram;
    }

    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * @param mixed $appid
     */
    public function setAppid($appid): void
    {
        $this->appid = $appid;
    }

    /**
     * @return mixed
     */
    public function getPagepath()
    {
        return $this->pagepath;
    }

    /**
     * @param mixed $pagepath
     */
    public function setPagepath($pagepath): void
    {
        $this->pagepath = $pagepath;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }
}