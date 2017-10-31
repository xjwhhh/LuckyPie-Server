<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 20:18
 */

class Share{
    public $postBasicInfo;
    public $postTime;
    public $postAddress;

    /**
     * @return mixed
     */
    public function getPostBasicInfo()
    {
        return $this->postBasicInfo;
    }

    /**
     * @param mixed $postBasicInfo
     */
    public function setPostBasicInfo($postBasicInfo)
    {
        $this->postBasicInfo = $postBasicInfo;
    }

    /**
     * @return mixed
     */
    public function getPostTime()
    {
        return $this->postTime;
    }

    /**
     * @param mixed $postTime
     */
    public function setPostTime($postTime)
    {
        $this->postTime = $postTime;
    }

    /**
     * @return mixed
     */
    public function getPostAddress()
    {
        return $this->postAddress;
    }

    /**
     * @param mixed $postAddress
     */
    public function setPostAddress($postAddress)
    {
        $this->postAddress = $postAddress;
    }


}