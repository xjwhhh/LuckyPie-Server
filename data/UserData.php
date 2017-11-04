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
        $user = new User();
        //查重
        $sql = <<<EOF
      SELECT * from user where account=$account and password=$password;
EOF;
        $result = $this->db->query($sql);
        if (!$result) {
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
            $user->setIdentity($row['identity']);
            $user->setIntroduction($row['identity']);
            $user->setGender($row['gender']);
            $user->setTelephone($row['telephone']);
            $user->setEmail($row['email']);
        }
        return $user;
    }

    //如何知道要更新的是哪些内容->全部更新
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


}

