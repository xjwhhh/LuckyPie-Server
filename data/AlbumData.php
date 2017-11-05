<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 17:10
 */

require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Album.php');

class AlbumData
{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    //对album的操作涉及三个表,album,albumphoto,albumtag

    public function selectAlbumData($userId)
    {
        $albumArray = array();
        $sql = <<<EOF
      SELECT * from album where userId=$userId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $album = new Album();
            $album->setId($row['id']);
            $album->setUserId($row['userId']);
            $album->setName($row['name']);
            $album->setDesc($row['description']);
            $album->setCreateTime($row['createTime']);
            $album->setUpdateTime($row['updateTime']);
            array_push($albumArray, $album);
        }
        return $albumArray;
    }


    public function insertAlbumData($album)
    {
        $returnAlbum = new Album();
        $userId = $album->getUserId();
        $name = $album->getName();
        $description = $album->getDesc();
        $createTime = $album->getCreateTime();
        $updateTime = $album->getUpdateTime();
        $sql = <<<EOF
      INSERT INTO album (userId,name,description,createTime,updateTime)
      VALUES ($userId,$name,$description,$createTime,$updateTime);
EOF;
        $ret = $this->db->exec($sql);
        //插入成功
        if ($ret) {
            $sql = <<<EOF
      SELECT * from album where userId=$userId and name=$name;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $returnAlbum->setId($row['id']);
                $returnAlbum->setUserId($row['userId']);
                $returnAlbum->setName($row['name']);
                $returnAlbum->setDesc($row['description']);
                $returnAlbum->setCreateTime($row['createTime']);
                $returnAlbum->setUpdateTime($row['updateTime']);
            }
        }
        return $returnAlbum;
    }

    public function updateAlbumData()
    {


    }

    public function deleteAlbumData($albumId)
    {
        $sql = <<<EOF
      DELETE from album where id=$albumId;
EOF;
        $ret = $this->db->exec($sql);
        if (!$ret) {
            return "fail";
        } else {
            return "success";
        }
    }


}