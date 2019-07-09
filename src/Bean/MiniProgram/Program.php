<?php
/**
 *
 * User: zs
 * Date: 2019/7/9
 * Email: <1769360227@qq.com>
 */


namespace EasySwoole\WeChat\Bean\MiniProgram;

use EasySwoole\Spl\SplBean;

class Program extends SplBean
{
    /** @var string */
    protected $is_comm_nearby ;
    /** @var string */
    protected $pic_list;
    /** @var string */
    protected $service_infos;
    /** @var string */
    protected $store_name;
    /** @var string */
    protected $hour;
    /** @var string */
    protected $credential;
    /** @var string */
    protected $address;
    /** @var string */
    protected $company_name;
    /** @var string */
    protected $qualification_list;
    /** @var string */
    protected $kf_info;
    /** @var string */
    protected $poi_id;

    /**
     * @return string
     */
    public function getIsCommNearby(): string
    {
        return $this->is_comm_nearby;
    }

    /**
     * @param string $is_comm_nearby
     */
    public function setIsCommNearby(string $is_comm_nearby): void
    {
        $this->is_comm_nearby = $is_comm_nearby;
    }

    /**
     * @return string
     */
    public function getPicList(): string
    {
        return $this->pic_list;
    }

    /**
     * @param string $pic_list
     */
    public function setPicList(string $pic_list): void
    {
        $this->pic_list = $pic_list;
    }

    /**
     * @return string
     */
    public function getServiceInfos(): string
    {
        return $this->service_infos;
    }

    /**
     * @param string $service_infos
     */
    public function setServiceInfos(string $service_infos): void
    {
        $this->service_infos = $service_infos;
    }

    /**
     * @return string
     */
    public function getStoreName(): string
    {
        return $this->store_name;
    }

    /**
     * @param string $store_name
     */
    public function setStoreName(string $store_name): void
    {
        $this->store_name = $store_name;
    }

    /**
     * @return string
     */
    public function getHour(): string
    {
        return $this->hour;
    }

    /**
     * @param string $hour
     */
    public function setHour(string $hour): void
    {
        $this->hour = $hour;
    }

    /**
     * @param string $credential
     */
    public function setCredential(string $credential): void
    {
        $this->credential = $credential;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->company_name;
    }

    /**
     * @param string $company_name
     */
    public function setCompanyName(string $company_name): void
    {
        $this->company_name = $company_name;
    }

    /**
     * @return string
     */
    public function getQualificationList(): string
    {
        return $this->qualification_list;
    }

    /**
     * @param string $qualification_list
     */
    public function setQualificationList(string $qualification_list): void
    {
        $this->qualification_list = $qualification_list;
    }

    /**
     * @return string
     */
    public function getKfInfo(): string
    {
        return $this->kf_info;
    }

    /**
     * @param string $kf_info
     */
    public function setKfInfo(string $kf_info): void
    {
        $this->kf_info = $kf_info;
    }

    /**
     * @return string
     */
    public function getPoiId(): string
    {
        return $this->poi_id;
    }

    /**
     * @param string $poi_id
     */
    public function setPoiId(string $poi_id): void
    {
        $this->poi_id = $poi_id;
    }


}