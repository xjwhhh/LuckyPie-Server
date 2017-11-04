<?php

/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:11
 */
require_once("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../data/ShareData.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class shareHandler extends SimpleHandler
{

    private $shareData;

    function __construct()
    {
        $this->shareData = new ShareData();
    }

    public function getHotShares()
    {

    }

    public function getFollowingShares()
    {

    }

    public function getExploreShares()
    {

    }

    public function addShare()
    {
        if (isset($_POST['shareInfo'])) {
            $shareInfo = $_POST['shareInfo'];
        }
        $temp = json_decode($shareInfo);
        print_r($temp);
        $share = new Share();
        $share->setDesc($temp->desc);
        $share->setUserId($temp->userId);
        $share->setImageUrls($temp->imageUrls);
        $share->setPostTime($temp->postTime);
        $share->setPostAddress($temp->postAddress);
//        print_r($album);
//        echo $temp->userId;

        $result = $this->shareData->insertShareData($share);

//        echo $datingInfo;
//        print_r($dating);
//        echo  $result;
//        echo json_encode($result);
    }

    public function updateShare()
    {

    }

    public function deleteShare()
    {

    }


}