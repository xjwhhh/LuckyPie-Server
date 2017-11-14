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

        $description="'".$description."'";
        $postTime="'".$postTime."'";
        $postAddress="'".$postAddress."'";

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

        $shareId = $returnShare->getId();
        $urlArray = array();//返回的imageURL
        //插入sharePhoto
        $diff=0;
        foreach ($photoArray as $base64Code) {
            $photoId = 0;
            //不查看照片是否已经上传过
            //上传至服务器
            preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Code, $result);
            $type = $result[2];
            $catalog=date('Ymd', time()) . "/";
            $new_file = "C:/Apache24/htdocs/LuckyPie-Server/photo/" .$catalog ;
            $http_file="http://localhost/LuckyPie-Server/photo/".$catalog;
            if (!file_exists($new_file)) {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $time=time();
            $new_file = $new_file . $time .$diff. ".{$type}";
            $http_file = $http_file . $time .$diff. ".{$type}";
            $diff=$diff+1;
            $base64Code = str_replace(" ", "+", $base64Code);
            $tt=str_replace($result[1], '', $base64Code);
            $ll=base64_decode($tt);
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
                return new Share();
            }
            //获得photoId插入sharePhoto
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
        foreach ($tagArray as $tag) {
            $tag="'".$tag."'";
            $tagId = -1;
            $tagSql = <<<EOF
select id from tag where type=$tag;
EOF;
            $tagRes = $this->db->query($tagSql);
            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                $tagId = $tagRow['id'];
            }
            $albumTagSql = <<<EOF
insert into albumTag values ($shareId,$tagId);
EOF;
            $albumTagRes = $this->db > exec($albumTagSql);
            if (!$albumTagRes) {
                return new Album();
            }

        }
        $returnShare->setTags($tagArray);
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

            $shareId = $share->getId();
            //获取photo
            $photoArray = array();
            $photoSql = <<<EOF
      SELECT photo.url from sharePhoto,photo where sharePhoto.shareId=$shareId and photo.id=sharePhoto.photoId;
EOF;
            $photoRes = $this->db->query($photoSql);
            while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                array_push($photoArray, $photoRow['url']);
            }
            $share->setImageUrls($photoArray);
            //获取tag todo 不匹配
            $tagArray = array();
            $tagSql = <<<EOF
      SELECT tag.type from shareTag,tag where shareTag.shareId=$shareId and tag.id=shareTag.tagId;
EOF;
            $tagRes = $this->db->query($tagSql);
            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                array_push($tagArray, $tagRow['type']);
            }
            $share->setTags($tagArray);

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
//        $sql = <<<EOF
//      SELECT f.followId from follow f,followGroup fg where fg.userId=$userId and fg.groupName=$groupName and f.gruopId=fg.groupId;
//EOF;
        $sql=<<<EOF
select followId from follow where followerId=$userId;
EOF;

        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($followIdArray, $row['followId']);
        }
//        print_r($followIdArray);
        $followIdArray=array_unique($followIdArray);
        //获取关注用户的分享
        $shareArray = array();
        foreach ($followIdArray as $followId) {
            $result = $this->selectSharesDataByUserId($followId);
            $shareArray = array_merge_recursive($shareArray, $result);
        }
//        print_r($shareArray);
        return $shareArray;
        //todo 按时间排序
    }
}