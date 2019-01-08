<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 18-12-30
 * Time: 下午10:12
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class MediaRequest extends SplBean
{
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_THUMB = 'thumb';

    protected $path;
    protected $data;
    protected $type;
    protected $title;
    protected $introduction;
    protected $description;

    /**
     * @return mixed
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * @param mixed $introduction
     */
    public function setIntroduction($introduction): void
    {
        $this->introduction = $introduction;
    }


    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        if ($this->description === null) {
            return json_encode([
               'title' => $this->getTitle(),
                'introduction' => $this->getIntroduction()
            ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }
}