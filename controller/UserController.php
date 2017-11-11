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

switch ($option){
    case "login":
        $userHandler=new UserHandler();
        $userHandler->login();
        break;

    case "register":
        $userHandler=new UserHandler();
        $userHandler->register();
        break;

    case "getBasicInfo":
//        echo "456";
        $userHandler=new UserHandler();
        $userHandler->getUserInfo();//todo
        break;

    case "updateInfo":
        $userHandler=new UserHandler();
        $userHandler->updateUserInfo();
        break;

    case "getExploreHotPhotographer":
        $userHandler=new UserHandler();
        $userHandler->getExploreHotPhotographer();
        break;

    case "getExploreBestPhotographer":
        $userHandler=new UserHandler();
        $userHandler->getExploreBestPhotographer();
        break;

    case "getExploreNewPhotographer":
        $userHandler=new UserHandler();
        $userHandler->getExploreNewPhotographer();
        break;

    case "getExploreHotModel":
        $userHandler=new UserHandler();
        $userHandler->getExploreHotModel();
        break;

    case "getExploreBestModel";
        $userHandler=new UserHandler();
        $userHandler->getExploreBestModel();
        break;

    case "getExploreNewModel":
        $userHandler=new UserHandler();
        $userHandler->getExploreNewModel();
        break;
}






