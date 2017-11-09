<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/31
 * Time: 22:47
 */

require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/User.php');

class UserData
{

    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertUserData($account, $password)
    {
        $account="'".$account."'";
        $password="'".$password."'";
        $user = new User();
        //查重
        $sql = <<<EOF
      SELECT * from user where account=$account;
EOF;
        $result = $this->db->query($sql);
        $count=0;
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $count++;
        }
       //无重复数据
        if ($count==0) {
            //插入
            $authority = 0;
            $sql = <<<EOF
      INSERT INTO USER (account,password,authority)
      VALUES ($account,$password,$authority);
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
        }
        return $user;
    }

    public function selectUserData($account,$password)
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
        }
        return $user;
    }

    //todo 如何知道要更新的是哪些内容->全部更新
    public function updateUserData($user)
    {
        $sql = <<<EOF
      UPDATE user set password=$user->getPasswor(),name=$user->getName(),identity=$user->getIdentity(),
      introduction=$user->getIntroduction(),gender=$user->getGender(),telephone=$user->getTelephone(),email=$user->getEmail()
      where id=$user->getId();
EOF;
        $ret = $this->db->exec($sql);
        if ($ret) {
            return $user;
        } else {
            return new User();
        }
    }

    public function selectHotPhotographer()
    {
        $userArray = array();
        //todo 点赞最多的一千个摄影师，随机选一百个展现
        $sql = <<<EOF
      SELECT user.id,user.account,user.password,user.authority,user.name,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
       from user,thumb 
       where identity="摄影师" and user.id=thumb.userId
       group by user.id
       order by num
       limit 1000
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
            array_push($userArray, $user);
        }
        return $userArray;

    }

    public function selectBestPhotographer()
    {
        $userArray = array();
        //todo 点赞数最高的100个摄影师
        $sql = <<<EOF
      SELECT user.id,user.account,user.password,user.authority,user.name,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
            array_push($userArray, $user);
        }
        return $userArray;
    }

    public function selectHotModel()
    {
        $userArray = array();
        //todo 点赞最多的一千个模特，随机选一百个展现
        $sql = <<<EOF
      SELECT user.id,user.account,user.password,user.authority,user.name,user.identity,user.introduction,user.gender,user.telephone,user.email,count(*) num
       from user,thumb 
       where identity="模特" and user.id=thumb.userId
       group by user.id
       order by num
       limit 1000
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
            array_push($userArray, $user);
        }
        return $userArray;
    }
}


