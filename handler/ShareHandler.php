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

        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        //todo groupName
        $groupName="全部";
        $result=$this->shareData->selectFollowingSharesByUserId($userId,$groupName);
        echo json_encode($result);

    }

    public function getExploreShares()
    {

    }

    public function getUserShares(){
        if (isset($_GET["id"])) {
            $userId = $_GET["id"];
        }
        $result=$this->shareData->selectSharesDataByUserId($userId);
        echo json_encode($result);
    }

    public function addShare()
    {
        if (isset($_POST['shareInfo'])) {
            $shareInfo = $_POST['shareInfo'];
        }
        $temp = json_decode($shareInfo);

        $share = new Share();
        $share->setUserId($temp->userId);
        $share->setDesc($temp->desc);
        $share->setImageUrls($temp->imageUrls);
        $share->setTags($temp->tags);
        $share->setPostTime($temp->postTime);
        $share->setPostAddress($temp->postAddress);
        $share->setForwardShareId($temp->forwardShareId);

        $result = $this->shareData->insertShareData($share);

        echo json_encode($result);
    }

    public function updateShare()
    {

    }

    public function deleteShare()
    {

    }


}