<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:44 AM
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class User extends SplBean
{
    protected $subscribe;
    protected $subscribe_time;
    protected $openid;
    protected $nickname;
    protected $sex;
    protected $language;
    protected $province;
    protected $city;
    protected $country;
    protected $headimgurl;
    protected $privilege;
    protected $unionid;
    protected $remark;
    protected $groupid;
    protected $tagid_list;

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param mixed $openid
     */
    public function setOpenid($openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province): void
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getHeadimgurl()
    {
        return $this->headimgurl;
    }

    /**
     * @param mixed $headimgurl
     */
    public function setHeadimgurl($headimgurl): void
    {
        $this->headimgurl = $headimgurl;
    }

    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param mixed $privilege
     */
    public function setPrivilege($privilege): void
    {
        $this->privilege = $privilege;
    }

    /**
     * @return mixed
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     * @param mixed $unionid
     */
    public function setUnionid($unionid): void
    {
        $this->unionid = $unionid;
    }

    /**
     * @return mixed
     */
    public function getSubscribe()
    {
        return $this->subscribe;
    }

    /**
     * @param mixed $subscribe
     */
    public function setSubscribe($subscribe): void
    {
        $this->subscribe = $subscribe;
    }

    /**
     * @return mixed
     */
    public function getSubscribeTime()
    {
        return $this->subscribe_time;
    }

    /**
     * @param mixed $subscribe_time
     */
    public function setSubscribeTime($subscribe_time): void
    {
        $this->subscribe_time = $subscribe_time;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark): void
    {
        $this->remark = $remark;
    }

    /**
     * @return mixed
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * @param mixed $groupid
     */
    public function setGroupid($groupid): void
    {
        $this->groupid = $groupid;
    }

    /**
     * @return mixed
     */
    public function getTagidList()
    {
        return $this->tagid_list;
    }

    /**
     * @param mixed $tagid_list
     */
    public function setTagidList($tagid_list): void
    {
        $this->tagid_list = $tagid_list;
    }
}