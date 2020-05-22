<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/5/19
 * Time: 23:44
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;

use EasySwoole\Spl\SplBean;
use EasySwoole\Spl\SplArray;


class DataCubeRequest extends SplBean
{
    protected $begin_date;
    protected $start_date;
    protected $end_date;
    protected $page;
    protected $page_size;
    protected $ad_slot;


    protected $list;
    protected $base_resp;
    protected $summary;
    protected $total_num;


    /**
     * @return SplArray
     */
    public function buildRequest() : SplArray
    {
        $data = $this->toArray(null, SplBean::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    public function setAdSlot($adSlot)
    {
        $this->ad_slot = $adSlot;
    }

    public function getAdSlot()
    {
        return $this->ad_slot;
    }

    public function setTotalNum($totalNum)
    {
        $this->total_num = $totalNum;
    }

    public function getTotalNum()
    {
        return $this->total_num;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setBaseResp($baseResp)
    {
        $this->base_resp = $baseResp;
    }

    public function getBaseResp()
    {
        return $this->base_resp;
    }

    /**
     * @param string $beginDate
     */
    public function setBeginDate(string $beginDate) :void
    {
        $this->begin_date = $beginDate;
    }

    /**
     * @return null|string
     */
    public function getBeginDate() : ?string
    {
        return $this->begin_date;
    }
    /**
     * @param string $endDate
     */
    public function setEndDate(string $endDate) :void
    {
        $this->end_date = $endDate;
    }

    /**
     * @return null|string
     */
    public function getEndDate() : ?string
    {
        return $this->end_date;
    }

    /**
     * @param $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    public function getList()
    {
        return $this->list;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPageSize($pageSize)
    {
        $this->page_size = $pageSize;
    }

    public function getPageSize()
    {
        return $this->page_size;
    }

    public function setStartDate($startDate)
    {
        $this->start_date= $startDate;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }




}