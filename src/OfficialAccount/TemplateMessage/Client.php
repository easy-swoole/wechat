<?php


namespace EasySwoole\WeChat\OfficialAccount\TemplateMessage;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{

    protected $message = [
        'touser' => '',
        'template_id' => '',
        'url' => '',
        'data' => [],
        'miniprogram' => '',
    ];

    protected $required = ['touser', 'template_id'];


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


    public function send(array $data = [])
    {
        $params = $this->formatMessage($data);

        $this->restoreMessage();

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/message/template/send',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    public function sendSubscription(array $data = [])
    {
        $params = $this->formatMessage($data);

        $this->restoreMessage();

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/message/template/subscribe',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    protected function formatMessage(array $data = [])
    {
        $params = array_merge($this->message, $data);

        foreach ($params as $key => $value) {
            if (in_array($key, $this->required, true) && empty($value) && empty($this->message[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $this->message[$key] : $value;
        }

        $params['data'] = $this->formatData($params['data'] ?? []);

        return $params;
    }


    protected function formatData(array $data)
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (\array_key_exists('value', $value)) {
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

    protected function restoreMessage()
    {
        $this->message = (new \ReflectionClass(static::class))->getDefaultProperties()['message'];
    }
}