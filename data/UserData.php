<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
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

    public function insertUserData()
    {

    }

    public function selectUserData($account, $password)
    {
        $sql = <<<EOF
      SELECT * from user where account=$account and password=$password;
EOF;

        $ret = $this->db->query($sql);
        $user=new User();
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $user->setAccount($row['account']);
            $user->setPassword($row['password']);
            $user->setAuthority($row['authority']);
        }
//        echo "Operation done successfully\n";
        return $user;
    }


}

//$userData=new UserData();
//$user=$userData->selectUserData('1','1');
//echo $user->getName();
//echo $user->getAccount();
//echo $user->getAuthority();
//echo $user->getPassword();
