<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 20:28
 */
class Date{
    public $postBasicInfo;
    public $cost;
    public $photoTime;
    public $photoAddress;
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
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getPhotoTime()
    {
        return $this->photoTime;
    }

    /**
     * @param mixed $photoTime
     */
    public function setPhotoTime($photoTime)
    {
        $this->photoTime = $photoTime;
    }

    /**
     * @return mixed
     */
    public function getPhotoAddress()
    {
        return $this->photoAddress;
    }

    /**
     * @param mixed $photoAddress
     */
    public function setPhotoAddress($photoAddress)
    {
        $this->photoAddress = $photoAddress;
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