<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/5/16
 * Time: 11:56 下午
 */
declare(strict_types=1);

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\PrivacyConfig;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 小程序用户隐私保护指引 - 设置小程序用户隐私保护指引
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/privacy_config/set_privacy_setting.html
     *
     * @param array $ownerSetting
     * @param int   $privacyVer
     * @param array $settingList
     * @param array $sdkPrivacyInfoList
     *
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setPrivacySetting(
        array $ownerSetting,
        int $privacyVer = 2,
        array $settingList = [],
        array $sdkPrivacyInfoList = []
    )
    {
        if (!in_array($privacyVer, [1, 2], true)) {
            throw new \InvalidArgumentException("The value of parameter a is only allowed to pass 1 and 2.");
        }

        $params = [
            'privacy_ver' => $privacyVer,
            'owner_setting' => $ownerSetting,
        ];
        if ($privacyVer === 2) {
            if (empty($settingList)) {
                throw new \InvalidArgumentException("Missing parameter settingList.");
            }
            $params['setting_list'] = $settingList;
        }
        if (!empty($sdkPrivacyInfoList)) {
            $params['sdk_privacy_info_list'] = $sdkPrivacyInfoList;
        }

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/cgi-bin/component/setprivacysetting",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response, $jsonData);
    }

    /**
     * 代小程序实现业务 - 小程序用户隐私保护指引 - 查询小程序用户隐私保护指引
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/privacy_config/get_privacy_setting.html
     *
     * @param int $privacyVer
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPrivacySetting(int $privacyVer = 2)
    {
        if (!in_array($privacyVer, [1, 2], true)) {
            throw new \InvalidArgumentException("The value of parameter a is only allowed to pass 1 and 2.");
        }

        $params = [
            'privacy_ver' => $privacyVer,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/cgi-bin/component/getprivacysetting",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    /**
     * 代小程序实现业务 - 小程序用户隐私保护指引 - 上传小程序用户隐私保护指引
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/privacy_config/upload_privacy_exfile.html
     *
     * @param string $filePath
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function uploadPrivacyExtFile(string $filePath)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->addFile($filePath, 'file')
            ->send($this->buildUrl(
                "/cgi-bin/component/uploadprivacyextfile",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }
}