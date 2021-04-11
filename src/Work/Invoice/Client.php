<?php

namespace EasySwoole\WeChat\Work\Invoice;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Invoice
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 查询电子发票
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90284
     *
     * @param string $cardId
     * @param string $encryptCode
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $cardId, string $encryptCode)
    {
        $params = [
            'card_id' => $cardId,
            'encrypt_code' => $encryptCode,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/card/invoice/reimburse/getinvoiceinfo',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量查询电子发票
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90287
     *
     * @param array $invoices
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function select(array $invoices)
    {
        $params = [
            'item_list' => $invoices,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/card/invoice/reimburse/getinvoiceinfobatch',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 更新发票状态
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90285
     *
     * @param string $cardId
     * @param string $encryptCode
     * @param string $status
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $cardId, string $encryptCode, string $status)
    {
        $params = [
            'card_id' => $cardId,
            'encrypt_code' => $encryptCode,
            'reimburse_status' => $status,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/card/invoice/reimburse/updateinvoicestatus',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 批量更新发票状态
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90286
     *
     * @param array $invoices
     * @param string $openid
     * @param string $status
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchUpdate(array $invoices, string $openid, string $status)
    {
        $params = [
            'openid' => $openid,
            'reimburse_status' => $status,
            'invoice_list' => $invoices,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/card/invoice/reimburse/updatestatusbatch',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }
}