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
    public function getUserInfo()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }
        $userData = new UserData();
        $user = $userData->selectUserDataById($id);
        echo json_encode($user);
    }

    public function updateUserInfo()
    {
        if (isset($_POST["userId"])) {
            $userId = $_POST["userId"];
        }
        if (isset($_POST["name"])) {
            $name = $_POST["name"];
        }
        if (isset($_POST["introduction"])) {
            $introduction = $_POST["introduction"];
        }
        if (isset($_POST["gender"])) {
            $gender = $_POST["gender"];
        }
        if (isset($_POST["identity"])) {
            $identity = $_POST["identity"];
        }
        if (isset($_POST["telephone"])) {
            $telephone = $_POST["telephone"];
        }
        if (isset($_POST["email"])) {
            $email = $_POST["email"];
        }

        $userData = new UserData();
        $user = $userData->updateUserBasicInfo($userId, $name,$introduction, $gender, $identity, $telephone, $email);
        echo json_encode($user);

    }

    public function getExploreHotPhotographer()
    {

    }

    public function getExploreBestPhotographer()
    {

    }


    public function getExploreNewPhotographer()
    {

    }


    public function getExploreHotModel()
    {

    }

    public function getExploreBestModel()
    {

    }

    public function getExploreNewModel()
    {

    }


}
