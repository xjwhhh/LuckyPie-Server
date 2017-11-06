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

switch ($option) {
    case "upload":
        $shareHandler = new ShareHandler();
        $shareHandler->addShare();
        break;

    case "update":
        $shareHandler = new ShareHandler();
        $shareHandler->updateShare();
        break;

    case "delete":
        $shareHandler = new ShareHandler();
        $shareHandler->deleteShare();
        break;

    case "getFollowShare":
        $shareHandler = new ShareHandler();
        $shareHandler->getFollowingShares();
        break;

    case "getExploreShare":
        $shareHandler = new ShareHandler();
        $shareHandler->getExploreShares();
        break;

    case "getHotShare":
        $shareHandler = new ShareHandler();
        $shareHandler->getHotShares();
        break;
}