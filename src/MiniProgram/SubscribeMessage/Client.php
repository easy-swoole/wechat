<?php

namespace EasySwoole\WeChat\MiniProgram\SubscribeMessage;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use function \array_key_exists;
use function \compact;
use function \implode;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\SubscribeMessage
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.addTemplate.html
 */
class Client extends BaseClient
{
    /**
     * @return array
     */
    protected function messageTemplate(): array
    {
        return [
            'touser' => '',
            'template_id' => '',
            'page' => '',
            'data' => [],
        ];
    }

    /**
     * @return string[]
     */
    protected function requiredKeys(): array
    {
        return ['touser', 'template_id', 'data'];
    }

    /**
     * Combine templates and add them to your personal template library under your account.
     * 组合模板并添加至帐号下的个人模板库
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.addTemplate.html
     *
     * @param string $tid
     * @param array $kidList
     * @param string|null $sceneDesc
     * @return mixed
     * @throws HttpException
     */
    public function addTemplate(string $tid, array $kidList, string $sceneDesc = null)
    {
        $sceneDesc = $sceneDesc ?? '';
        $data = compact('tid', 'kidList', 'sceneDesc');

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
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.deleteTemplate.html
     *
     * @param string $id
     * @return bool
     * @throws HttpException
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
     * Get the category of the applet account.
     * 获取小程序账号的类目
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.getCategory.html
     *
     * @return mixed
     * @throws HttpException
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

    /**
     * Get keyword list under template title.
     * 获取模板标题下的关键词列表
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.getPubTemplateKeyWordsById.html
     *
     * @param string $tid
     * @return mixed
     * @throws HttpException
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
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.getPubTemplateTitleList.html
     *
     * @param array $ids
     * @param int $start
     * @param int $limit
     * @return mixed
     * @throws HttpException
     */
    public function getTemplateTitles(array $ids, int $start = 0, int $limit = 30)
    {
        $ids = implode(',', $ids);
        $query = compact('ids', 'start', 'limit');
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
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.getTemplateList.html
     *
     * @return mixed
     * @throws HttpException
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
     * Send a template message.
     * 发送订阅消息
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.send.html
     *
     * @param array $data
     * @return mixed
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function send(array $data = [])
    {
        $params = $this->formatMessage($data);

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
        $message = $this->messageTemplate();
        $params = array_merge($message, $data);

        foreach ($params as $key => $value) {
            if (in_array($key, $this->requiredKeys(), true) && empty($value) && empty($message[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $message[$key] : $value;
        }

        foreach ($params['data'] as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('value', $value)) {
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
}
