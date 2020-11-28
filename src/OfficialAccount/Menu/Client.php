<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/25
 * Time: 11:21
 */

namespace EasySwoole\WeChat\OfficialAccount\Menu;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * 自定义菜单
 * 包括:创建接口,查询接口,删除接口,个性化菜单接口,获取自定义菜单配置实现
 * 参考微信文档 https://developers.weixin.qq.com/doc/offiaccount/Custom_Menus/Querying_Custom_Menus.html
 * */
class Client extends BaseClient
{
    const URL = [
        'create' => '/cgi-bin/menu/create',
        'get_current_selfmenu_info' => '/cgi-bin/get_current_selfmenu_info',
        'delete' => '/cgi-bin/menu/delete',
        'addconditional' => '/cgi-bin/menu/addconditional',
        'delconditional' => '/cgi-bin/menu/delconditional',
        'trymatch' => '/cgi-bin/menu/trymatch',
        'get' => '/cgi-bin/menu/get'
    ];

    /**
     * 创建接口
     * @param array $data 自定义标签需要的数据
     * @return array
     * @throws HttpException
     */
    function create(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody(
                $this->jsonDataToStream($data)
            )
            ->send($this->buildUrl(
                self::URL['create'],
                [
                    'access_token' => $this->getAccessToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 查询接口
     * @return array
     * @throws HttpException
     */
    public function queryConfig()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                self::URL['get_current_selfmenu_info'],
                [
                    'access_token' => $this->getAccessToken(),
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 删除接口
     * @return array
     * @throws HttpException
     */
    public function delete()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                self::URL['delete'],
                [
                    'access_token' => $this->getAccessToken(),
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 个性化菜单接口:创建个性化菜单
     * @param array $data
     * @return array
     * @throws HttpException
     */
    function addconditional(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody(
                $this->jsonDataToStream($data)
            )
            ->send($this->buildUrl(
                self::URL['addconditional'],
                [
                    'access_token' => $this->getAccessToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 个性化菜单接口:删除个性化菜单
     * @param string $menuId 菜单id，可以通过自定义菜单查询接口获取。
     * @return array
     * @throws HttpException
     */
    function delconditional(string $menuId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody(
                $this->jsonDataToStream([
                    'menuid' => $menuId,
                ])
            )
            ->send($this->buildUrl(
                self::URL['delconditional'],
                [
                    'access_token' => $this->getAccessToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 个性化菜单接口:测试个性化菜单匹配结果
     * @param string $userId 可以是粉丝的OpenID，也可以是粉丝的微信号。
     * @return array
     * @throws HttpException
     */
    function match(string $userId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody(
                $this->jsonDataToStream([
                    'user_id' => $userId,
                ])
            )
            ->send($this->buildUrl(
                self::URL['trymatch'],
                [
                    'access_token' => $this->getAccessToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取自定义菜单配置
     * @return array
     * @throws HttpException
     */
    public function query()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                self::URL['get'],
                [
                    'access_token' => $this->getAccessToken(),
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    protected function getAccessToken()
    {
        return $this->app[ServiceProviders::AccessToken]->getToken();
    }
}