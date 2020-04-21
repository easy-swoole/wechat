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
    protected $scene;
    protected $title;
    protected $data = [];

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

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
    public function getScene()
    {
        return $this->scene;
    }

    /**
     * @param mixed $scene
     */
    public function setScene($scene): void
    {
        $this->scene = $scene;
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
    public function setMiniprogram(array $miniprogram): void
    {
        $this->miniprogram = $miniprogram;
    }

    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->miniprogram['appid'];
    }

    /**
     * @param mixed $appid
     */
    public function setAppid($appid): void
    {
        $this->miniprogram['appid'] = $appid;
    }

    /**
     * @return mixed
     */
    public function getPagepath()
    {
        return $this->miniprogram['pagepath'];
    }

    /**
     * @param mixed $pagepath
     */
    public function setPagepath($pagepath): void
    {
        $this->miniprogram['pagepath'] = $pagepath;
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
     * @return array
     */
    public function getSendMessage() : array
    {
        $message = $this->toArray(null, self::FILTER_NOT_NULL);

        $tmpData = Array();
        foreach ($message['data'] as $key => $val) {
            if (is_array($val)) {
                if (isset($val['value'])) {
                    $tmpData[$key] = $val;
                    continue;
                }

                if (count($val) >= 2) {
                    $tmpData[$key] = [
                        'value' => $val[0],
                        'color' => $val[1]
                    ];
                    continue;
                }
            }
            $tmpData[$key] = ['value' => $val];
        }
        $message['data'] = $tmpData;
        return $message;
    }
}