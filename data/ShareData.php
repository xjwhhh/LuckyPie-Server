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
        echo "success";
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