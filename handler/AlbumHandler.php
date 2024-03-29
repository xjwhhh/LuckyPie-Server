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

    public function getAlbumByAlbumId()
    {
        if (isset($_GET['albumId'])) {
            $albumId = $_GET['albumId'];
        }
        $result=$this->albumData->selectAlbumByAlbumId($albumId);
        echo json_encode($result);

    }

    public function addAlbum()
    {
        if (isset($_POST['albumInfo'])) {
            $albumInfo = $_POST['albumInfo'];
        }
        $temp = json_decode($albumInfo);
        $album = new Album();
        $album->setName($temp->name);
        $album->setDesc($temp->desc);
        $album->setUserId($temp->userId);
        $album->setImageUrls($temp->imageUrls);
        $album->setTags($temp->tags);
        $album->setCreateTime($temp->createTime);
        $album->setUpdateTime($temp->updateTime);

        $result = $this->albumData->insertAlbumData($album);
        echo json_encode($result);

    }

    public function updateAlbum()
    {

    }

    public function deleteAlbum()
    {
        if (isset($_POST['albumId'])) {
            $albumId = $_POST['albumId'];
        }
        $result=$this->albumData->deleteAlbumData($albumId);
        echo json_encode($result);

    }

    public function getUserAlbums(){
        if (isset($_GET["id"])) {
            $userId = $_GET["id"];
        }
        $result=$this->albumData->getUserAlbumByUserId($userId);
        echo json_encode($result);
    }

    public function searchAlbum(){
        if (isset($_POST["content"])) {
            $content = $_POST["content"];
        }
        $result=$this->albumData->selectAlbumBySearch($content);
        echo json_encode($result);
    }

}