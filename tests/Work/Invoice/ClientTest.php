<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 22:47
 */

namespace EasySwoole\WeChat\Tests\Work\Invoice;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Invoice\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/card/invoice/reimburse/getinvoiceinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->get('CARDID', 'ENCRYPTCODE'));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get('CARDID', 'ENCRYPTCODE'));
    }

    public function testSelect()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('select.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/card/invoice/reimburse/getinvoiceinfobatch', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $invoces = [
            [
                [
                    'card_id' => 'CARDID1',
                    'encrypt_code' => 'ENCRYPTCODE1'],
                [
                    'card_id' => 'ENCRYPTCODE1',
                    'encrypt_code' => 'ENCRYPTCODE2'
                ]
            ]
        ];

        $this->assertIsArray($client->select($invoces));

        $this->assertSame(json_decode($this->readMockResponseJson('select.json'), true), $client->select($invoces));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/card/invoice/reimburse/updateinvoicestatus', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->update('card_id', 'ENCRYPTCODE', 'INVOICE_REIMBURSE_INIT'));
    }

    public function testBatchUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/card/invoice/reimburse/updatestatusbatch', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $invoice = [
            [
                'card_id' => 'cardid1',
                'encrypt_code' => 'code1'],
            [
                'card_id' => 'cardid2',
                'encrypt_code' => 'code2'
            ],
        ];

        $this->assertTrue($client->batchUpdate($invoice, 'OPENID', 'INVOICE_REIMBURSE_INIT'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}