<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:41
 */
require_once (dirname(__FILE__) . '/../handler/DatingHandler.php');
$option = "";
if(isset($_GET["option"]))
    $option = $_GET["option"];
if(isset($_POST["option"]))
    $option = $_POST["option"];

switch ($option){
    case "upload":
        $datingHandler=new DatingHandler();
        $datingHandler->addDating();
        break;

    case "update":
        $datingHandler=new DatingHandler();
        $datingHandler->updateDating();
        break;

    case "delete":
        $datingHandler=new DatingHandler();
        $datingHandler->deleteDating();
        break;

    case "getUserDating":
        $datingHandler=new DatingHandler();
        $datingHandler->getUserDating();
        break;

    case "getFollowDating":
        $datingHandler=new DatingHandler();
        $datingHandler->getFollowingDating();
        break;

    case "getExploreDating":
        $datingHandler=new DatingHandler();
        $datingHandler->getExploreDating();
        break;

}
