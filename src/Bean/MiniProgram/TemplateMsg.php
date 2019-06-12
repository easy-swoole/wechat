<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:17
 */

namespace EasySwoole\WeChat\Bean\MiniProgram;


use EasySwoole\Spl\SplBean;

class TemplateMsg extends SplBean
{
    /** @var string */
    protected $touser;
    /** @var string */
    protected $template_id;
    /** @var string */
    protected $page;
    /** @var string */
    protected $form_id;
    /** @var array */
    protected $data;
    /** @var string */
    protected $emphasis_keyword;

    /**
     * @return string
     */
    public function getTouser(): string
    {
        return $this->touser;
    }

    /**
     * @param string $touser
     */
    public function setTouser(string $touser): void
    {
        $this->touser = $touser;
    }

    /**
     * @return string
     */
    public function getTemplateId(): string
    {
        return $this->template_id;
    }

    /**
     * @param string $template_id
     */
    public function setTemplateId(string $template_id): void
    {
        $this->template_id = $template_id;
    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * @param string $page
     */
    public function setPage(string $page): void
    {
        $this->page = $page;
    }

    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->form_id;
    }

    /**
     * @param string $form_id
     */
    public function setFormId(string $form_id): void
    {
        $this->form_id = $form_id;
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
     * @return string
     */
    public function getEmphasisKeyword(): string
    {
        return $this->emphasis_keyword;
    }

    /**
     * @param string $emphasis_keyword
     */
    public function setEmphasisKeyword(string $emphasis_keyword): void
    {
        $this->emphasis_keyword = $emphasis_keyword;
    }

    /**
     * @return array
     */
    public function getSendMessage(): array
    {
        $message = $this->toArray(null, self::FILTER_NOT_NULL);
        if (!empty($message['data'])) {
            foreach ($message['data'] as $key => $data) {
                $key = key(reset($data));
                $value = current(reset($data));
                $message['data'][$key] = [$key => ['value' => $value]];
            }
        }
        return $message;
    }
}