<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\MaterialClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class MaterialClientTest extends TestCase
{
    public function testUploadImage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('material_upload_image.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/material/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=icon', $request->getUri()->getQuery());
        }, $response, $app);

        $path = dirname(__FILE__) . '/mock_data/material_upload_image.json';

        $client = new MaterialClient($app);
        $this->assertIsArray($client->uploadImage($path));
        $this->assertEquals(json_decode($this->readMockResponseJson('material_upload_image.json'), true), $client->uploadImage($path));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}