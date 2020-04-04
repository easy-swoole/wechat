<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/3/31
 * Time: 23:46
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;

use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\Bean\PostFile;

class CustomerService extends SplBean
{
    /** @var string 完整客服账号，格式为：账号前缀@公众号微信号 */
    protected $kf_account;
    /** @var string 客服昵称 */
    protected $kf_nick;
    /** @var string 客服工号 */
    protected $kf_id;
    /** @var string 客服昵称，最长6个汉字或12个英文字符 */
    protected $nickname;
    /** @var string 客服账号登录密码，格式为密码明文的32位加密MD5值。该密码仅用于在公众平台官网的多客服功能中使用，若不使用多客服功能，则不必设置密码 */
    protected $password;
    /** @var PostFile 该参数仅在设置客服头像时出现，是form-data中媒体文件标识，有filename、filelength、content-type等信息 */
    protected $media;

    /**
     * @return null|string
     */
    public function getKfAccount() : ?string
    {
        return $this->kf_account ?? null;
    }

    /**
     * @param $kfAccount
     */
    public function setKfAccount($kfAccount)
    {
        $this->kf_account = $kfAccount;
    }

    /**
     * @return null|string
     */
    public function getNickname() : ?string
    {
        return $this->nickname ?? null;
    }

    /**
     * @param $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return null|string
     */
    public function getPassword() : ?string
    {
        return $this->password ?? null;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * @return null|string
     */
    public function getMedia() : ?string
    {
        return $this->media ?? null;
    }

    /**
     * @param $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return array
     */
    public function getSendMessage() : array
    {
        $message = $this->toArray(null, self::FILTER_NOT_NULL);

        return $message;
    }
}