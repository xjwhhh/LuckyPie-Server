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

    }

    public function getFollowingDating()
    {

    }

    public function getExploreDating()
    {

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

    }

}