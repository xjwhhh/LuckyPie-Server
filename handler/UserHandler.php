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
        $user = $this->userData->selectUserDataById($id);
        echo json_encode($user);
    }

    public function updateUserHead(){
        if (isset($_POST["userId"])) {
            $userId = $_POST["userId"];
        }
        if (isset($_POST["headInfo"])) {
            $headInfo = $_POST["headInfo"];
        }
        $result=$this->userData->updateUserHead($userId,$headInfo);
        echo json_encode($result);
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

        $user = $this->userData->updateUserBasicInfo($userId, $name, $introduction, $gender, $identity, $telephone, $email);
        echo json_encode($user);

    }

    public function getExploreHotPhotographer()
    {
        $result = $this->userData->selectHotPhotographer();
        echo json_encode($result);
    }

    public function getExploreBestPhotographer()
    {
        $result = $this->userData->selectBestPhotographer();
        echo json_encode($result);

    }


    public function getExploreNewPhotographer()
    {
        $result = $this->userData->selectNewPhotographer();
        echo json_encode($result);

    }


    public function getExploreHotModel()
    {
        $result = $this->userData->selectHotModel();
        echo json_encode($result);
    }

    public function getExploreBestModel()
    {
        $result = $this->userData->selectBestModel();
        echo json_encode($result);
    }

    public function getExploreNewModel()
    {
        $result = $this->userData->selectNewModel();
        echo json_encode($result);
    }

    public function follow()
    {
        if (isset($_POST["followId"])) {
            $followId = $_POST["followId"];
        }
        if (isset($_POST["followerId"])) {
            $followerId = $_POST["followerId"];
        }
        $result=$this->userData->follow($followId, $followerId);
        echo json_encode($result);
    }

    public function removeFollow()
    {
        if (isset($_POST["followId"])) {
            $followId = $_POST["followId"];
        }
        if (isset($_POST["followerId"])) {
            $followerId = $_POST["followerId"];
        }
        $result=$this->userData->removeFollow($followId, $followerId);
        echo json_encode($result);
    }

    public function isFollow(){
        if (isset($_POST["userId"])) {
            $userId = $_POST["userId"];
        }
        if (isset($_POST["checkUserId"])) {
            $checkUserId = $_POST["checkUserId"];
        }
        $result=$this->userData->isFollow($userId,$checkUserId);
        echo json_encode($result);
    }

    public function getFollow(){
        if (isset($_GET["userId"])) {
            $userId = $_GET["userId"];
        }
        $result=$this->userData->getFollow($userId);
        echo json_encode($result);
    }

    public function getFollower(){
        if (isset($_GET["userId"])) {
            $userId = $_GET["userId"];
        }
        $result=$this->userData->getFollower($userId);
        echo json_encode($result);
    }

}
