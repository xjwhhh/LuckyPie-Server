<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/31
 * Time: 20:41
 */
require_once (dirname(__FILE__) . '/../handler/UserHandler.php');
$option = "";

//echo "345678";
if(isset($_GET["option"]))
    $option = $_GET["option"];
if(isset($_POST["option"]))
    $option = $_POST["option"];

//echo $option;
$userHandler=new UserHandler();


switch ($option){
    case "login":
        $userHandler->login();
        break;

    case "register":
        $userHandler->register();
        break;

    case "getBasicInfo":
        $userHandler->getUserInfo();
        break;

    case "updateHead":
        $userHandler->updateUserHead();
        break;

    case "updateInfo":
        $userHandler->updateUserInfo();
        break;

    case "getExploreHotPhotographer":
        $userHandler->getExploreHotPhotographer();
        break;

    case "getExploreBestPhotographer":
        $userHandler->getExploreBestPhotographer();
        break;

    case "getExploreNewPhotographer":
        $userHandler->getExploreNewPhotographer();
        break;

    case "getExploreHotModel":
        $userHandler->getExploreHotModel();
        break;

    case "getExploreBestModel";
        $userHandler->getExploreBestModel();
        break;

    case "getExploreNewModel":
        $userHandler->getExploreNewModel();
        break;

    case "follow":
        $userHandler->follow();
        break;

    case "removeFollow":
        $userHandler->removeFollow();
        break;

    case "isFollow":
        $userHandler->isFollow();
        break;

    case "getFollow":
        $userHandler->getFollow();
        break;

    case "getFollower":
        $userHandler->getFollower();
        break;

    case "search":
        $userHandler->searchUser();
        break;

}






