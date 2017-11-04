<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:43
 */
require_once("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../data/AlbumData.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class albumHandler extends SimpleHandler
{

    private $albumData;

    function __construct()
    {
        $this->albumData = new AlbumData();
    }

    public function getAlbum()
    {

    }

    public function addAlbum()
    {
        if (isset($_POST['albumInfo'])) {
            $albumInfo = $_POST['albumInfo'];
        }
        $temp = json_decode($albumInfo);
//        print_r($temp);
        $album = new Album();
        $album->setName($temp->name);
        $album->setDesc($temp->desc);
        $album->setUserId($temp->userId);
        $album->setImageUrls($temp->imageUrls);
        $album->setCreateTime($temp->createTime);
        $album->setUpdateTime($temp->updateTime);
//        print_r($album);
//        echo $temp->userId;

        $result = $this->albumData->insertAlbumData($album);

//        echo $datingInfo;
//        print_r($dating);
//        echo  $result;
        echo json_encode($result);

    }

    public function updateAlbum()
    {

    }

    public function deleteAlbum()
    {

    }
}