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

    }
}