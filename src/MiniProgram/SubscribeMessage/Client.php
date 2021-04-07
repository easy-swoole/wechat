<?php

namespace EasySwoole\WeChat\MiniProgram\SubscribeMessage;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\SubscribeMessage
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.addTemplate.html
 */
class Client extends BaseClient
{
    protected $message = [
        'touser' => '',
        'template_id' => '',
        'page' => '',
        'data' => [],
    ];

    protected $required = [
        'touser',
        'template_id',
        'data'
    ];

    /**
     * Send a template message.
     * 发送订阅消息
     *
     * @param array $data
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function send(array $data = [])
    {
        $params = $this->formatMessage($data);

        $this->restoreMessage();

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/message/subscribe/send',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * @param array $data
     * @return array
     * @throws InvalidArgumentException
     */
    protected function formatMessage(array $data = [])
    {
        $params = array_merge($this->message, $data);

        foreach ($params as $key => $value) {
            if (in_array($key, $this->required, true) && empty($value) && empty($this->message[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $this->message[$key] : $value;
        }

        foreach ($params['data'] as $key => $value) {
            if (is_array($value)) {
                if (\array_key_exists('value', $value)) {
                    $params['data'][$key] = ['value' => $value['value']];

                    continue;
                }

                if (count($value) >= 1) {
                    $value = [
                        'value' => $value[0],
//                        'color' => $value[1],// color unsupported
                    ];
                }
            } else {
                $value = [
                    'value' => strval($value),
                ];
            }

            $params['data'][$key] = $value;
        }

        return $params;
    }

    /**
     * Restore message.
     */
    protected function restoreMessage()
    {
        $this->message = (new \ReflectionClass(static::class))->getDefaultProperties()['message'];
    }

    /**
     * Combine templates and add them to your personal template library under your account.
     * 组合模板并添加至帐号下的个人模板库
     *
     * @param string $tid
     * @param array $kidList
     * @param string|null $sceneDesc
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function addTemplate(string $tid, array $kidList, string $sceneDesc = null)
    {
        $sceneDesc = $sceneDesc ?? '';
        $data = \compact('tid', 'kidList', 'sceneDesc');

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/wxaapi/newtmpl/addtemplate',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Delete personal template under account.
     * 删除帐号下的个人模板
     *
     * @param string $id
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/7 22:18
     * @author: XueSi
     * @email: <1592328848@qq.com>
     */
    public function deleteTemplate(string $id)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['priTmplId' => $id]))
            ->send($this->buildUrl(
                '/wxaapi/newtmpl/deltemplate',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Get keyword list under template title.
     * 获取模板标题下的关键词列表
     *
     * @param string $tid
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTemplateKeywords(string $tid)
    {
        $query = [
            'tid' => $tid,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/newtmpl/getpubtemplatekeywords',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Get the title of the public template under the category to which the account belongs.
     * 获取帐号所属类目下的公共模板标题
     *
     * @param array $ids
     * @param int $start
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTemplateTitles(array $ids, int $start = 0, int $limit = 30)
    {
        $ids = \implode(',', $ids);
        $query = \compact('ids', 'start', 'limit');
        $query['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/newtmpl/getpubtemplatetitles', $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Get list of personal templates under the current account.
     * 获取当前帐号下的个人模板列表
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/7 22:29
     * @author: XueSi
     * @email: <1592328848@qq.com>
     */
    public function getTemplates()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/newtmpl/gettemplate', ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Get the category of the applet account.
     * 获取小程序账号的类目
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/7 22:30
     * @author: XueSi
     * @email: <1592328848@qq.com>
     */
    public function getCategory()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/newtmpl/getcategory', ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}