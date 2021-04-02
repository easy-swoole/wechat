<?php

namespace EasySwoole\WeChat\MiniProgram\TemplateMessage;

use EasySwoole\WeChat\OfficialAccount\TemplateMessage\Client as BaseClient;

/**
 * Class Client
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Live
 */
class Client extends BaseClient
{
    public const API_SEND = 'cgi-bin/message/wxopen/template/send';

    protected $message = [
        'touser' => '',
        'template_id' => '',
        'page' => '',
        'form_id' => '',
        'data' => [],
        'emphasis_keyword' => '',
    ];

    /**
     * {@inheritdoc}.
     */
    protected $required = ['touser', 'template_id', 'form_id'];

    /**
     * @param int $offset
     * @param int $count
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list(int $offset, int $count)
    {
        return $this->queryPost('cgi-bin/wxopen/template/library/list', compact('offset', 'count'));
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $id)
    {
        return $this->queryPost('cgi-bin/wxopen/template/library/get', compact('id'));
    }

    /**
     * @param string $id
     * @param array  $keyword
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add(string $id, array $keyword)
    {
        return $this->queryPost('cgi-bin/wxopen/template/add', [
            'id' => $id,
            'keyword_id_list' => $keyword,
        ]);
    }

    /**
     * @param string $templateId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(string $templateId)
    {
        return $this->queryPost('cgi-bin/wxopen/template/del', [
            'template_id' => $templateId,
        ]);
    }

    /**
     * @param int $offset
     * @param int $count
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTemplates(int $offset, int $count)
    {
        return $this->queryPost('cgi-bin/wxopen/template/list', compact('offset', 'count'));
    }

    public function queryPost($api, $param)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                '/'.$api,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
