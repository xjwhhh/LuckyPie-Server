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

$datingHandler=new DatingHandler();


switch ($option){
    case "upload":
        $datingHandler->addDating();
        break;

    case "update":
        $datingHandler->updateDating();
        break;

    case "delete":
        $datingHandler->deleteDating();
        break;

    case "getUserDating":
        $datingHandler->getUserDating();
        break;

    case "getFollowDating":
        $datingHandler->getFollowingDating();
        break;

    case "getExploreDating":
        $datingHandler->getExploreDating();
        break;

    case "search":
        $datingHandler->searchDating();
        break;

}
