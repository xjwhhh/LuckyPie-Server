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

    private function getAlbumImagesAndTags($album)
    {
        $albumId = $album->getId();
//        echo $albumId;
        //获取photo
        $photoArray = array();
        $photoSql = <<<EOF
      SELECT photo.url from albumPhoto,photo where albumPhoto.albumId=$albumId and photo.id=albumPhoto.photoId;
EOF;
        $photoRes = $this->db->query($photoSql);
        while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
            array_push($photoArray, $photoRow['url']);
        }
        $album->setImageUrls($photoArray);
        //获取tag
        $tagArray = array();
        $tagSql = <<<EOF
      SELECT tag.type from albumTag,tag where albumTag.albumId=$albumId and tag.id=albumTag.tagId;
EOF;
        $tagRes = $this->db->query($tagSql);
        while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
            array_push($tagArray, $tagRow['type']);
        }
        $album->setTags($tagArray);
        return $album;
    }

    public function getUserAlbumByUserId($userId)
    {
        $albumArray = array();
        $sql = <<<EOF
      SELECT * from album where userId=$userId;
EOF;
        $res = $this->db->query($sql);
        $albumId = -1;
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $album = new Album();
            $album->setId($row['id']);
            $album->setUserId($row['userId']);
            $album->setName($row['title']);
            $album->setDesc($row['description']);
            $album->setCreateTime($row['createTime']);
            $album->setUpdateTime($row['updateTime']);

            $albumId = $album->getId();
            //获取photo
            $photoArray = array();
            $photoSql = <<<EOF
      SELECT photo.url from albumPhoto,photo where albumPhoto.albumId=$albumId and photo.id=albumPhoto.photoId;
EOF;
            $photoRes = $this->db->query($photoSql);
            while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                array_push($photoArray, $photoRow['url']);
            }
            $album->setImageUrls($photoArray);
            //获取tag todo 不匹配
            $tagArray = array();
            $tagSql = <<<EOF
      SELECT tag.type from albumTag,tag where albumTag.albumId=$albumId and tag.id=albumTag.tagId;
EOF;
            $tagRes = $this->db->query($tagSql);
            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                array_push($tagArray, $tagRow['type']);
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

        $name = "'" . $name . "'";
        $description = "'" . $description . "'";
        $createTime = "'" . $createTime . "'";
        $updateTime = "'" . $updateTime . "'";


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

        $albumId = $returnAlbum->getId();

        $urlArray = array();//返回的imageURL
        //插入albumPhoto
        $diff = 0;
        foreach ($photoArray as $base64Code) {
            $photoId = 0;
            //不查看照片是否已经上传过
            //上传至服务器
            preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Code, $result);
            $type = $result[2];
            $catalog = date('Ymd', time()) . "/";
            $new_file = "C:/Apache24/htdocs/LuckyPie-Server/photo/" . $catalog;
            $http_file = "http://localhost/LuckyPie-Server/photo/" . $catalog;
            if (!file_exists($new_file)) {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $time = time();
            $new_file = $new_file . $time . $diff . ".{$type}";
            $http_file = $http_file . $time . $diff . ".{$type}";
            $diff = $diff + 1;
            $base64Code = str_replace(" ", "+", $base64Code);
            $tt = str_replace($result[1], '', $base64Code);
            $ll = base64_decode($tt);
            file_put_contents($new_file, $ll);
            $now = date("Y-m-d H:i:s.u", time());
            $now = "'" . $now . "'";
            $http_file = "'" . $http_file . "'";
            $photoSql = <<<EOF
insert into photo (uploadTime,url) values($now,$http_file);
EOF;
            $photoRes = $this->db->exec($photoSql);
            //插入photo成功
            if ($photoRes) {
                $photoSql = <<<EOF
select * from photo where uploadTime=$now and url=$http_file;
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
        foreach ($tagArray as $tag) {
            $tag = "'" . $tag . "'";
            $tagId = -1;
            $tagSql = <<<EOF
select id from tag where type=$tag;
EOF;
            $tagRes = $this->db->query($tagSql);
            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                $tagId = $tagRow['id'];
            }
            $albumTagSql = <<<EOF
insert into albumTag values ($albumId,$tagId);
EOF;
            $albumTagRes = $this->db > exec($albumTagSql);
            if (!$albumTagRes) {
                return new Album();
            }

        }
        $returnAlbum->setTags($tagArray);
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


    public function selectAlbumByAlbumId($albumId)
    {
        $album = new Album();
        $sql = <<<EOF
select * from album where id=$albumId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $album->setId($row['id']);
            $album->setUserId($row['userId']);
            $album->setName($row['title']);
            $album->setDesc($row['description']);
            $album->setCreateTime($row['createTime']);
            $album->setUpdateTime($row['updateTime']);
            $album = $this->getAlbumImagesAndTags($album);
        }

        return $album;


    }

    public function selectAlbumBySearch($content)
    {
        $content = "%" . $content . "%";
        $content = "'" . $content . "'";
        $albumArray = array();
        $sql = <<<EOF
select * from album where description like $content;
EOF;

        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $album = new Album();
            $album->setId($row['id']);
            $album->setUserId($row['userId']);
            $album->setName($row['title']);
            $album->setDesc($row['description']);
            $album->setCreateTime($row['createTime']);
            $album->setUpdateTime($row['updateTime']);
            $album=$this->getAlbumImagesAndTags($album);
            array_push($albumArray,$album);

        }

        return $albumArray;
    }


}