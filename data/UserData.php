<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/31
 * Time: 22:47
 */

require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/User.php');
require_once(dirname(__FILE__) . '/../entity/ResultMessage.php');

class UserData
{

    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertUserData($account, $password)
    {
        $account = "'" . $account . "'";
        $password = "'" . $password . "'";
        $user = new User();
        //查重
        $sql = <<<EOF
      SELECT * from user where account=$account;
EOF;
        $result = $this->db->query($sql);
        $count = 0;
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $count++;
        }
        //无重复数据
        if ($count == 0) {
            //插入
            $authority = 0;
            $headUrl="http://localhost/LuckyPie-Server/photo/default/head.png";
            $headUrl="'".$headUrl."'";
            $sql = <<<EOF
      INSERT INTO USER (account,password,name,authority,head)
      VALUES ($account,$password,"乐拍成员",$authority,$headUrl);
EOF;
            $ret = $this->db->exec($sql);
            //填充数据
            if ($ret) {
                $sql = <<<EOF
      SELECT * from user where account=$account and password=$password;
EOF;
                $res = $this->db->query($sql);
                $user = new User();
                while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                    $user->setId($row['id']);
                    $user->setAccount($row['account']);
                    $user->setPassword($row['password']);
                    $user->setAuthority($row['authority']);
                    $user->setHead($row['head']);
                }
            }
        }
        return $user;
    }

    public function selectUserDataById($id)
    {
        $sql = <<<EOF
      SELECT * from user where id=$id;
EOF;
        $ret = $this->db->query($sql);
        $user = new User();
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setGender($row['gender']);
            $user->setIntroduction($row['introduction']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
        }
        return $user;
    }

    public function selectUserData($account, $password)
    {
        $sql = <<<EOF
      SELECT * from user where account=$account and password=$password;
EOF;
        $ret = $this->db->query($sql);
        $user = new User();
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
        }
        return $user;
    }

    public function updateUserHead($userId,$headInfo)
    {
        $resultMessage=new ResultMessage();
        $photoId = 0;
        //不查看照片是否已经上传过
        //上传至服务器
        preg_match('/^(data:\s*image\/(\w+);base64,)/', $headInfo, $result);
        $type = $result[2];
        $catalog = date('Ymd', time()) . "/";
        $new_file = "C:/Apache24/htdocs/LuckyPie-Server/photo/" . $catalog;
        $http_file = "http://localhost/LuckyPie-Server/photo/" . $catalog;
        if (!file_exists($new_file)) {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $time = time();
        $new_file = $new_file . $time . ".{$type}";
        $http_file = $http_file . $time . ".{$type}";
        $base64Code = str_replace(" ", "+", $headInfo);
        $tt = str_replace($result[1], '', $base64Code);
        $ll = base64_decode($tt);
        file_put_contents($new_file, $ll);
        $http_file = "'" . $http_file . "'";
        $headSql = <<<EOF
update user set head=$http_file where id=$userId;
EOF;
        $headRes = $this->db->exec($headSql);
        if ($headRes) {
            $resultMessage->setResult("success");
        } else {
           $resultMessage->setResult("fail");

        }
        return $resultMessage;

    }

    //todo 如何知道要更新的是哪些内容->全部更新
    public function updateUserBasicInfo($userId, $name, $introduction, $gender, $identity, $telephone, $email)
    {
        $user = new User();
        if ($introduction == null) {
            $introduction = "他很懒哦，暂无自我介绍";
        }
        if ($telephone == null) {
            $telephone = "-1";
        }
        if ($email == null) {
            $email = "-1";
        }

        //更新失败的原因是null
        $name = "'" . $name . "'";
        $introduction = "'" . $introduction . "'";
        $gender = "'" . $gender . "'";
        $identity = "'" . $identity . "'";
        $telephone = "'" . $telephone . "'";
        $email = "'" . $email . "'";

        //查重
        $sql = <<<EOF
      SELECT * from user where name=$name;
EOF;
        $result = $this->db->query($sql);
        $count = 0;
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            if ($row['id'] != $userId) {
                $count++;
            }
        }
        if ($count > 0) {
            return new User();
        }

        //无重复
        $sql = <<<EOF
      UPDATE user set name=$name,introduction=$introduction,gender=$gender,identity=$identity,telephone=$telephone,email=$email
      where id=$userId;
EOF;
        $ret = $this->db->exec($sql);
        if ($ret) {
            $user->setId($userId);
            return $user;
        } else {
            return new User();
        }
    }

    public function selectHotPhotographer()
    {
        $userArray = array();
        //todo 应该是被点赞最多的，所以thumb里最好存储被点赞的userId
        //todo 点赞最多的一千个摄影师，随机选一百个展现
//        $sql = <<<EOF
//      SELECT user.id,user.account,user.password,user.authority,user.name,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
//       from user,thumb
//       where identity="摄影师" and user.id=thumb.userId
//       group by user.id
//       order by num
//       limit 1000
//       ;
//EOF;
        $sql = <<<EOF
select * from user where IDENTITY ="摄影师";
EOF;

        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
            array_push($userArray, $user);
        }
        return $userArray;

    }

    public function selectBestPhotographer()
    {
        $userArray = array();
        //todo 点赞数最高的100个摄影师
        $sql = <<<EOF
      SELECT user.id,user.account,user.password,user.authority,user.name,user.head,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
       from user,thumb 
       where identity="摄影师" and user.id=thumb.userId
       group by user.id
       order by num
       limit 100
       ;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
            array_push($userArray, $user);
        }
        return $userArray;
    }

    public function selectNewPhotographer()
    {
        $userArray = array();
        //todo 最近一百个注册的摄影师
        $sql = <<<EOF
      SELECT *
      from user
       where identity="摄影师"
       order by id desc
       limit 100
       ;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
            array_push($userArray, $user);
        }
        return $userArray;
    }

    public function selectHotModel()
    {
        $userArray = array();
        //todo 点赞最多的一千个模特，随机选一百个展现
//        $sql = <<<EOF
//      SELECT user.id,user.account,user.password,user.authority,user.name,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
//       from user,thumb
//       where identity="模特" and user.id=thumb.userId
//       group by user.id
//       order by num
//       limit 1000
//       ;
//EOF;
        $sql=<<<EOF
select * from user where identity="模特";
EOF;

        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
            array_push($userArray, $user);
        }
        return $userArray;
    }

    public function selectBestModel()
    {
        $userArray = array();
        //todo 点赞最多的一百个模特
        $sql = <<<EOF
      SELECT user.id,user.account,user.password,user.authority,user.name,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
       from user,thumb 
       where identity="模特" and user.id=thumb.userId
       group by user.id
       order by num
       limit 100
       ;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
            array_push($userArray, $user);
        }
        return $userArray;
    }

    public function selectNewModel()
    {
        $userArray = array();
        //todo 最近一百个注册的模特
        $sql = <<<EOF
      SELECT *
      from user
       where identity="模特"
       order by id desc
       limit 100
       ;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
            $user->setName($row['name']);
            $user->setHead($row['head']);
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['introduction']);
            $user->setGender($row['gender']);
            if ($row['telephone'] == "-1") {
                $user->setTelephone(null);
            } else {
                $user->setTelephone($row['telephone']);
            }
            if ($row['email'] == "-1") {
                $user->setEmail(null);
            } else {
                $user->setEmail($row['email']);
            }
            array_push($userArray, $user);
        }
        return $userArray;
    }

    public function follow($followId, $followerId)
    {
        $resultMessage=new ResultMessage();
        $sql = <<<EOF
insert into follow(followId,followerId,groupId) values($followId,$followerId,-1);
EOF;
        $ret = $this->db->exec($sql);
        if($ret){
            $resultMessage->setResult("success");

        }else{
            $resultMessage->setResult("fail");
        }
        return $resultMessage;
    }

    public function isFollow($userId,$checkUserId){
        $resultMessage=new ResultMessage();
        $resultMessage->setResult("fail");
        $sql=<<<EOF
select * from follow where followerId=$userId and followId=$checkUserId;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $resultMessage->setResult("success");
        }
        return $resultMessage;
    }

    public function getFollow($userId){
        $followIdArray=array();
        $sql=<<<EOF
select followId from follow where followerId=$userId;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
           array_push($followIdArray,$row['followId']);
        }
        $followIdArray=array_unique($followIdArray);
        return $followIdArray;
    }

    public function getFollower($userId){
        $followerIdArray=array();
        $sql=<<<EOF
select followerId from follow where followId=$userId;
EOF;
        $ret = $this->db->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            array_push($followerIdArray,$row['followerId']);
        }
        $followerIdArray=array_unique($followerIdArray);
        return $followerIdArray;
    }
}


