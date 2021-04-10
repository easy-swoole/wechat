<?php


namespace EasySwoole\WeChat\OfficialAccount\TemplateMessage;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use function \array_key_exists;

class Client extends BaseClient
{

    public const API_SEND = '/cgi-bin/message/template/send';

    /**
     * @return array
     */
    protected function messageTemplate(): array
    {
        return [
            'touser' => '',
            'template_id' => '',
            'url' => '',
            'data' => [],
            'miniprogram' => '',
        ];
    }

    /**
     * @return string[]
     */
    protected function requiredKeys(): array
    {
        return ['touser', 'template_id'];
    }

    /**
     * @param $industryOne
     * @param $industryTwo
     * @return bool
     * @throws HttpException
     */
    public function setIndustry($industryOne, $industryTwo)
    {
        $params = [
            'industry_id1' => $industryOne,
            'industry_id2' => $industryTwo,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/template/api_set_industry',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @return mixed
     * @throws HttpException
     */
    public function getIndustry()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/template/get_industry',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param $shortId
     * @return mixed
     * @throws HttpException
     */
    public function addTemplate($shortId)
    {
        $params = ['template_id_short' => $shortId];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/template/api_add_template',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @return mixed
     * @throws HttpException
     */
    public function getPrivateTemplates()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/template/get_all_private_template',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param $templateId
     * @return bool
     * @throws HttpException
     */
    public function deletePrivateTemplate($templateId)
    {
        $params = ['template_id' => $templateId];
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/template/del_private_template',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param array $data
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function send(array $data = [])
    {
        $params = $this->formatMessage($data);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                static::API_SEND,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param array $data
     * @return bool
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function sendSubscription(array $data = [])
    {
        $params = $this->formatMessage($data);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/message/template/subscribe',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

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

        $params['data'] = $this->formatData($params['data'] ?? []);

        return $params;
    }


    /**
     * @param array $data
     * @return array
     */
    protected function formatData(array $data)
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('value', $value)) {
                    $formatted[$key] = $value;

                    continue;
                }

                if (count($value) >= 2) {
                    $value = [
                        'value' => $value[0],
                        'color' => $value[1],
                    ];
                }
            } else {
                $value = [
                    'value' => strval($value),
                ];
            }

            $formatted[$key] = $value;
        }

        return $formatted;
    }
}
