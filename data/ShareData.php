<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:31
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Share.php');

class ShareData
{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    //对share的操作涉及五个表,share,sharePhoto,shareTag,comment,thumb

    public function insertShareData($share)
    {
        $returnShare = new Share();
        $userId = $share->getUserId();
        $description = $share->getDesc();
        $photoArray = $share->getImageUrls();
        $tagArray = $share->getTags();
        $postTime = $share->getPostTime();
        $postAddress = $share->getPostAddress();
        $forwardShareId = $share->getForwardShareId();


        //插入share
        $sql = <<<EOF
      INSERT INTO share (userId,description,postTime,postAddress,forwardShareId)
      VALUES ($userId,$description,$postTime,$postAddress,$forwardShareId);
EOF;
        $ret = $this->db->exec($sql);
        //插入share成功
        if ($ret) {
            $sql = <<<EOF
      SELECT * from share where userId=$userId and postTime=$postTime;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $returnShare->setId($row['id']);
                $returnShare->setUserId($row['userId']);
                $returnShare->setDesc($row['description']);
                $returnShare->setPostTime($row['postTime']);
                $returnShare->setPostAddress($row['postAddress']);
                $returnShare->setForwardShareId($row['forwardShareId']);
            }
        } else {
            return new Share();
        }

        $urlArray = array();//返回的imageURL
        //插入sharePhoto
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
                return new Share();
            }
            //获得photoId插入sharePhoto
            $shareId = $returnShare->getId();
            $sharePhotoSql = <<<EOF
insert into sharePhoto (photoId,shareId) values ($photoId,$shareId);
EOF;
            $sharePhotoRes = $this->db->exec($sharePhotoSql);
            if (!$sharePhotoRes) {
                return new Album();
            }
        }
        $returnShare->setImageUrls($urlArray);

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
        return $returnShare;
    }

    public function updateShareData()
    {

    }

    public function deleteShareData($shareId)
    {
        $sql = <<<EOF
      DELETE from share where id=$shareId;
      DELETE from sharePhoto where shareId=$shareId;
      DELETE from shareTag where shareId=$shareId;
      DELETE from thumb where shareId=$shareId;
      DELETE from comment where replyShareId=$shareId;
EOF;
        $ret = $this->db->exec($sql);
        if (!$ret) {
            return "fail";
        } else {
            return "success";
        }
    }

    public function selectSharesDataByUserId($userId)
    {
        $shareArray = array();
        $sql = <<<EOF
      SELECT * from share where userId=$userId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $share = new Share();
            $share->setId($row['id']);
            $share->setUserId($row['userId']);
            $share->setDesc($row['description']);
            $share->setPostTime($row['postTime']);
            $share->setPostAddress($row['postAddress']);
            $share->setForwardShareId($row['forwardShareId']);
            array_push($shareArray, $share);
        }
        return $shareArray;

    }

    public function selectHotShares()
    {
        //todo 一个思路，仅先获取shareIdArray，除重后再用shareId获取所有信息
        $shareArray = array();
        $timeLimit = date("Y-m-d H:i:s", strtotime("-1 day"));
        //12小时内点赞降序排列
        $sql = <<<EOF
      SELECT s.id,s.userId,s.description,s.postTime,s.postAddress,s.forwareShareId,count(t.userId) thumbCounts
      from share s ,thumb t where s.shareId=t.shareId and s.postTime> $timeLimit order by thumbCounts desc;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $share = new Share();
            $share->setId($row['id']);
            $share->setUserId($row['userId']);
            $share->setDesc($row['description']);
            $share->setPostTime($row['postTime']);
            $share->setPostAddress($row['postAddress']);
            $share->setForwardShareId($row['forwardShareId']);
            array_push($shareArray, $share);
        }
        //12小时内评论降序排列
        $sql = <<<EOF
      SELECT s.id,s.userId,s.description,s.postTime,s.postAddress,s.forwareShareId,count(c.id) commentCounts
      from share s ,comment c where s.shareId=c.replyShareId and s.postTime> $timeLimit order by commentCounts desc;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $share = new Share();
            $share->setId($row['id']);
            $share->setUserId($row['userId']);
            $share->setDesc($row['description']);
            $share->setPostTime($row['postTime']);
            $share->setPostAddress($row['postAddress']);
            $share->setForwardShareId($row['forwardShareId']);
            array_push($shareArray, $share);
        }
        return $shareArray;
    }

    //根据标签名获取分享
    public function selectExploreSharesByUserId($tagName)
    {
        $shareArray = array();
        $sql = <<<EOF
      SELECT s.id,s.userId,s.description,s.postTime,s.postAddress,s.forwareShareId
      from share s,shareTag st,tag t where st.shareId=s.id and st.tagId=t.id and t.name=$tagName;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $share = new Share();
            $share->setId($row['id']);
            $share->setUserId($row['userId']);
            $share->setDesc($row['description']);
            $share->setPostTime($row['postTime']);
            $share->setPostAddress($row['postAddress']);
            $share->setForwardShareId($row['forwardShareId']);
            array_push($shareArray, $share);
        }
        return $shareArray;

    }

    public function selectFollowingSharesByUserId($userId, $groupName)
    {
        //获取分组关注
        $followIdArray = array();
        $sql = <<<EOF
      SELECT f.followId from follow f,followGroup fg where fg.userId=$userId and fg.groupName=$groupName and f.gruopId=fg.groupId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($followIdArray, $row['followId']);
        }
        //获取关注用户的分享
        $shareArray = array();
        foreach ($followIdArray as $followId) {
            $result = $this->selectSharesDataByUserId($followId);
            $shareArray = array_merge_recursive($shareArray, $result);
        }
        return $shareArray;
        //todo 按时间排序
    }
}