<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:32
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Dating.php');
class DatingData{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertDating($dating){
        return "success";
    }

    public function updateDating(){

    }

    public function deleteDating(){

    }

    public function selectDatingDataByUserId($userId){
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
            $dating->setPhotoTime($row['photoTime']);
            $dating->setPostTime($row['postTime']);
            $dating->setPhotoAddress($row['photoAddress']);
            $dating->setPostAddress($row['postAddress']);
            array_push($datingArray, $dating);
        }
        return $datingArray;

    }

    //可能不需要
    public function selectHotDating(){

    }

    public function selectExploreDatingByUserId($userId){

    }

    //
    public function selectFollowingDatingByUserId($userId,$groupName){
        $userIdArray=array();
//        $sql = <<<EOF
//      SELECT followId from follow where userId=$userId;
//EOF;

    }


}