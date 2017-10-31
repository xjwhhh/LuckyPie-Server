<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 20:03
 */

class Album
{
    public $postBasicInfo;

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



}