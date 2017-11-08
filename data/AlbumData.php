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

    //对album的操作涉及三个表,album,albumPhoto,albumTag

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
            //获取photo
            $photoArray = array();
            $photoSql = <<<EOF
      SELECT photo.url from albumPhoto,photo where albumPhoto.albumId=$album->getId() and photo.id=albumPhoto.photoId;
EOF;
            $photoRes = $this->db->query($photoSql);
            while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                array_push($photoArray, $photoRow['url']);
            }
            $album->setImageUrls($photoArray);
            //获取tag
            $tagArray = array();
            $tagSql = <<<EOF
      SELECT tag.name from albumTag,tag where albumTag.albumId=$album->getId() and tag.id=albumTag.tagId;
EOF;
            $tagRes = $this->db->query($tagSql);
            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                array_push($tagArray, $tagRow['name']);
            }
            $album->setTags($tagArray);
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
        $photoArray = $album->getImageUrls();
        $tagArray = $album->getTags();
        $createTime = $album->getCreateTime();
        $updateTime = $album->getUpdateTime();


        //插入album
        $sql = <<<EOF
      INSERT INTO album (userId,title,description,createTime,updateTime)
      VALUES ($userId,$name,$description,$createTime,$updateTime);
EOF;
        $ret = $this->db->exec($sql);
        //插入album成功
        if ($ret) {
            $sql = <<<EOF
      SELECT * from album where userId=$userId and title=$name;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $returnAlbum->setId($row['id']);
                $returnAlbum->setUserId($row['userId']);
                $returnAlbum->setName($row['title']);
                $returnAlbum->setDesc($row['description']);
                $returnAlbum->setCreateTime($row['createTime']);
                $returnAlbum->setUpdateTime($row['updateTime']);
            }
        } else {
            return new Album();
        }

        $urlArray = array();//返回的imageURL
        //插入albumPhoto
        foreach ($photoArray as $base64Code) {
            $photoId = 0;
            //todo 将照片base64解码,但保存之后是损坏的，需要解决
            //不查看照片是否已经上传过
            //上传至服务器
            preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Code, $result);
            $type = $result[2];
            $new_file = "C:/Apache24/htdocs/LuckyPie-Server/photo/" . date('Ymd', time()) . "/";
            if (!file_exists($new_file)) {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . time() . ".{$type}";
            file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64Code)));
            $now = date("Y-m-d H:i:s", time());
            $now = "'" . $now . "'";
            $new_file = "'" . $new_file . "'";
            $photoSql = <<<EOF
insert into photo (uploadTime,url) values($now,$new_file);
EOF;
            $photoRes = $this->db->exec($photoSql);
            //插入photo成功
            if ($photoRes) {
                $photoSql = <<<EOF
select * from photo where uploadTime=$now and url=$new_file;
EOF;
                $photoRes = $this->db->query($photoSql);
                //返回图片在服务器存储的位置
                while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                    $photoId = $photoRow['id'];
                    array_push($urlArray, $photoRow['url']);
                }
            } else {
                return new Album();
            }
            //获得photoId插入albumPhoto
            $albumId = $returnAlbum->getId();
            $albumPhotoSql = <<<EOF
insert into albumPhoto (photoId,albumId) values ($photoId,$albumId);
EOF;
            $albumPhotoRes = $this->db->exec($albumPhotoSql);
            if (!$albumPhotoRes) {
                return new Album();
            }
        }
        $returnAlbum->setImageUrls($urlArray);

        //插入albumTag

//        foreach ($tagArray as $tag) {
//            $tagId = -1;
//            $tagSql = <<<EOF
//select id from tag where name=$tag;
//EOF;
//            //todo 在tag表里插入数据
//            $tagRes = $this->db->query($tagSql);
//            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
//                $tagId = $tagRow['id'];
//            }
//            $albumTagSql = <<<EOF
//insert into albumTag values ($returnAlbum->getId(),$tagId);
//EOF;
//            $albumTagRes = $this->db > exec($albumTagSql);
//            if (!$albumTagRes) {
//                return new Album();
//            }
//
//        }
//        print_r($returnAlbum);
        return $returnAlbum;
    }

    public function updateAlbumData()
    {


    }

    public function deleteAlbumData($albumId)
    {
        $sql = <<<EOF
      DELETE from album where id=$albumId;
      DELETE from albumPhoto where albumId=$albumId;
      DELETE from albumTag where albumId=$albumId;
EOF;
        $ret = $this->db->exec($sql);
        if (!$ret) {
            return "fail";
        } else {
            return "success";
        }
    }


}