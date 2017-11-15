<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:11
 */
require_once(dirname(__FILE__) . '/../handler/ShareHandler.php');
$option = "";
if (isset($_GET["option"]))
    $option = $_GET["option"];
if (isset($_POST["option"]))
    $option = $_POST["option"];

$shareHandler = new ShareHandler();

switch ($option) {
    case "upload":
        $shareHandler->addShare();
        break;

    case "update":
        $shareHandler->updateShare();
        break;

    case "delete":
        $shareHandler->deleteShare();
        break;

    case "getUserShare":
        $shareHandler->getUserShares();
        break;

    case "getFollowShare":
        $shareHandler->getFollowingShares();
        break;

    case "getExploreShare":
        $shareHandler->getExploreShares();
        break;

    case "getHotShare":
        $shareHandler->getHotShares();
        break;

    case "doThumb":
        $shareHandler->doThumb();
        break;

    case "cancelThumb":
        $shareHandler->cancelThumb();
        break;

    case "getUserLike":
        $shareHandler->getUserLikes();
        break;

}