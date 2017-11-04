<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/31
 * Time: 22:14
 */
require_once("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../entity/User.php');
require_once(dirname(__FILE__) . '/../data/UserData.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class UserHandler extends SimpleHandler
{

    private $userData;

    function __construct()
    {
        $this->userData = new UserData();
    }

    //post:account,password
    public function login()
    {
        if (isset($_POST["account"])) {
            $account = $_POST["account"];
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        $user = $this->userData->selectUserData($account, $password);
        echo json_encode($user);
    }

    //post:account,password
    public function register()
    {
        if (isset($_POST["account"])) {
            $account = $_POST["account"];
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        $user = $this->userData->insertUserData($account, $password);
        echo json_encode($user);

    }

    //get:id
    public function getUserInfo($id)
    {
        $user = new User();
        $user->setAlbums("2345");
        $user->setShares("2345");
        $user->setLikes("2345");
        $user->setAccount("1");
        $user->setId("1");

        echo json_encode($user);
    }

    public function updateUserInfo()
    {

    }

    public function getExplorePhotographer()
    {

    }

    public function getExploreModel()
    {

    }


}

//$userHandler=new UserHandler();
//$userHandler->login();