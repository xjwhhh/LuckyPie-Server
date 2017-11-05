<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:32
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Dating.php');

class DatingData
{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    //对dating的操作涉及三个表,dating,datingPhoto,datingTag

    public function insertDating($dating)
    {
        $returnDating = new Album();
        $userId = $dating->getUserId();
        $description = $dating->getDesc();
        $cost = $dating->getCost();
        $photoTime = $dating->getPhotoTime();
        $photoAddress = $dating->getPhotoAddress();
        $postTime = $dating->getPostTime();
        $postAddress = $dating->getPostAddress();
        $sql = <<<EOF
      INSERT INTO dating (userId,description,cost,photoTime,photoAddress,postTime,postAddress)
      VALUES ($userId,$description,$cost,$photoTime,$photoAddress,$postTime,$postAddress);
EOF;
        $ret = $this->db->exec($sql);
        //插入成功,todo 如何获取刚刚插入的dating,现在这个效率应该不高
        if ($ret) {
            $sql = <<<EOF
      SELECT * from dating where userId=$userId order by id asc;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $returnDating->setId($row['id']);
                $returnDating->setUserId($row['userId']);
                $returnDating->setName($row['name']);
                $returnDating->setDesc($row['description']);
                $returnDating->setCreateTime($row['createTime']);
                $returnDating->setUpdateTime($row['updateTime']);
            }
        }
        return $returnDating;


    }

    public function updateDating()
    {

    }

    public function deleteDating($datingId)
    {
        $sql = <<<EOF
      DELETE from dating where id=$datingId;
      DELETE from datingPhoto where datingId=$datingId;
      DELETE from datingTag where datingId=$datingId;
EOF;
        $ret = $this->db->exec($sql);
        if (!$ret) {
            return "fail";
        } else {
            return "success";
        }
    }

    public function selectDatingDataByUserId($userId)
    {
        $datingArray = array();
        $sql = <<<EOF
      SELECT * from dating where userId=$userId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $dating = new Dating();
            $dating->setId($row['id']);
            $dating->setUserId($row['userId']);
            $dating->setDesc($row['description']);
            $dating->setCost($row['cost']);
            $dating->setPhotoTime($row['photoTime']);
            $dating->setPostTime($row['postTime']);
            $dating->setPhotoAddress($row['photoAddress']);
            $dating->setPostAddress($row['postAddress']);
            array_push($datingArray, $dating);
        }
        return $datingArray;

    }

    //可能不需要
    public function selectHotDating()
    {

    }

    public function selectExploreDatingByUserId($tagName)
    {
        $datingArray = array();
        $sql = <<<EOF
      SELECT s.id,s.userId,s.description,s.cost,s.photoTime,s.photoAddress,s.postTime,s.postAddress
      from dating s,datingTag st,tag t where st.datingId=s.id and st.tagId=t.id and t.name=$tagName;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $dating = new Dating();
            $dating->setId($row['id']);
            $dating->setUserId($row['userId']);
            $dating->setDesc($row['description']);
            $dating->setCost($row['cost']);
            $dating->setPhotoTime($row['photoTime']);
            $dating->setPostTime($row['postTime']);
            $dating->setPhotoAddress($row['photoAddress']);
            $dating->setPostAddress($row['postAddress']);
            array_push($datingArray, $dating);
        }
        return $datingArray;

    }

    //
    public function selectFollowingDatingByUserId($userId, $groupName)
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
        //获取关注用户的约拍
        $shareArray = array();
        foreach ($followIdArray as $followId) {
            $result = $this->selectDatingDataByUserId($followId);
            $shareArray = array_merge_recursive($shareArray, $result);
        }
        return $shareArray;
        //todo 按时间排序


    }


}