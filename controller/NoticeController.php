<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:36
 */

require_once (dirname(__FILE__) . '/../handler/NoticeHandler.php');
$option = "";
if(isset($_GET["option"]))
    $option = $_GET["option"];
if(isset($_POST["option"]))
    $option = $_POST["option"];
$noticeHandler=new noticeHandler();


switch ($option) {

    case "getNotice":
        $noticeHandler->getNotice();
        break;

    case "getNewThumbNotice":
        $noticeHandler->getNewThumbNotice();
        break;

    case "getNewCommentNotice":
        $noticeHandler->getNewCommentNotice();
        break;

    case "getOldThumbNotice":
        $noticeHandler->getOldThumbNotice();
        break;

    case "getOldCommentNotice":
        $noticeHandler->getOldCommentNotice();
        break;

    case "setAllIsReadTrue":
        $noticeHandler->setAllIsReadTrue();
        break;

    case "doShareThumb":
        $noticeHandler->doShareThumb();
        break;

    case "cancelShareThumb":
        $noticeHandler->cancelShareThumb();
        break;

    case "getShareComment":
        $noticeHandler->getShareComment();
        break;

    case "doShareComment":
        $noticeHandler->addShareComment();
        break;


}