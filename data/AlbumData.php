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
            $photoArray=array();
            $photoSql=<<<EOF
      SELECT photo.url from albumPhoto,photo where albumPhoto.albumId=$album->getId() and photo.id=albumPhoto.photoId;
EOF;
            $photoRes = $this->db->query($photoSql);
            while($photoRow=$photoRes->fetchArray(SQLITE3_ASSOC)){
                array_push($photoArray,$photoRow['url']);
            }
            $album->setImageUrls($photoArray);
            //获取tag
            $tagArray=array();
            $tagSql=<<<EOF
      SELECT tag.name from albumTag,tag where albumTag.albumId=$album->getId() and tag.id=albumTag.tagId;
EOF;
            $tagRes = $this->db->query($tagSql);
            while($tagRow=$tagRes->fetchArray(SQLITE3_ASSOC)){
                array_push($tagArray,$tagRow['name']);
            }
            $album->setTags($tagArray);
            array_push($albumArray, $album);
        }
        return $albumArray;
    }


    public function insertAlbumData($album)
    {
        $returnAlbum = $album;
        $userId = $album->getUserId();
        $name = $album->getName();
        $description = $album->getDesc();
        $createTime = $album->getCreateTime();
        $updateTime = $album->getUpdateTime();
        //插入album
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
//                $returnAlbum->setUserId($row['userId']);
//                $returnAlbum->setName($row['name']);
//                $returnAlbum->setDesc($row['description']);
//                $returnAlbum->setCreateTime($row['createTime']);
//                $returnAlbum->setUpdateTime($row['updateTime']);
            }
        }
        else{
            return new Album();
        }
        //插入albumPhoto
        $photoArray = $album->getImageUrls();
        foreach ($photoArray as $url) {
            $photoId=0;
//            //todo 不知道是否需要看该照片是否已经上传过
//            $photoSql=<<<EOF
//    select id from photo where url=$url
//EOF;
//            $photoRes=$this->db->query($photoSql);

            //todo date
            $now = date();
            $photoSql = <<<EOF
insert into photo values($now,$url);
EOF;
            $photoRes = $this->db->exec($photoSql);
            //插入photo成功
            if ($photoRes) {
                $photoSql = <<<EOF
select * from photo where uploadTine=$now and url=$url;
EOF;
                $photoRes = $this->db->exec($photoSql);
                while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                    $photoId = $photoRow['id'];
                }
            }
            else{
                return new Album();
            }

            //插入albumPhoto
            $albumPhotoSql = <<<EOF
insert into albumPhoto values ($photoId,$returnAlbum->getId());
EOF;
            $albumPhotoRes = $this->db->exec($albumPhotoSql);
            if(!$albumPhotoRes){
                return new Album();
            }
        }

        $tagArray=$album->getTags();
        foreach ($tagArray as $tag){
            $tagSql=<<<EOF
select id from tag where name=$tag;
EOF;
            $tagRes=$this->db->query($tagSql);
            //todo
//            while($)

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