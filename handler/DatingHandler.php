<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:41
 */

require_once("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../data/DatingData.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class datingHandler extends SimpleHandler
{

    private $datingData;

    function __construct()
    {
        $this->datingData = new DatingData();
    }

    public function getHotDating()
    {
        $result=$this->datingData->selectHotDating();
        echo json_encode($result);
    }

    public function getFollowingDating()
    {
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        $result=$this->datingData->selectFollowingDatingByUserId($userId);
        echo json_encode($result);

    }

    public function getExploreDating()
    {
        if (isset($_POST['address'])) {
            $address = $_POST['address'];
        }
        if (isset($_POST['cost'])) {
            $cost = $_POST['cost'];
        }
        if (isset($_POST['identity'])) {
            $identity = $_POST['identity'];
        }
        if (isset($_POST['gender'])) {
            $gender = $_POST['gender'];
        }
        $result=$this->datingData->selectExploreDatingByConditions($address,$cost,$identity,$gender);
        echo json_encode($result);

    }

    public function getUserDating()
    {
        if (isset($_GET["id"])) {
            $userId = $_GET["id"];
        }
        $result = $this->datingData->selectDatingDataByUserId($userId);
        echo json_encode($result);

    }

    public function addDating()
    {
        if (isset($_POST['datingInfo'])) {
            $datingInfo = $_POST['datingInfo'];
        }
        $temp = json_decode($datingInfo);

        $dating = new Dating();
        $dating->setUserId($temp->userId);
        $dating->setDesc($temp->desc);
        $dating->setCost($temp->cost);
        $dating->setImageUrls($temp->imageUrls);
        $dating->setTags($temp->tags);
        $dating->setPostTime($temp->postTime);
        $dating->setPostAddress($temp->postAddress);
        $dating->setPhotoTime($temp->photoTime);
        $dating->setPhotoAddress($temp->photoAddress);

        $result = $this->datingData->insertDating($dating);
        echo json_encode($result);
    }

    public function updateDating()
    {

    }

    public function deleteDating()
    {
        if (isset($_POST['datingId'])) {
            $datingId = $_POST['datingId'];
        }
        $result=$this->datingData->deleteDating($datingId);
        echo json_encode($result);

    }

    public function searchDating(){
        if (isset($_POST["content"])) {
            $content = $_POST["content"];
        }
        $result=$this->datingData->selectDatingBySearch($content);
        echo json_encode($result);
    }

}