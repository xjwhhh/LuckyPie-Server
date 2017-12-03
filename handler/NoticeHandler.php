<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:36
 */

require_once("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../data/NoticeData.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class noticeHandler extends SimpleHandler{

    private $noticeData;

    function __construct()
    {
        $this->noticeData = new NoticeData();
    }

    public function getNewThumbNotice(){
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        $result=$this->noticeData->selectNewThumbNotice($userId);
        echo json_encode($result);
    }

    public function getNewCommentNotice(){
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        $result=$this->noticeData->selectNewCommentNotice($userId);
        echo json_encode($result);
    }

    public function getOldThumbNotice(){
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        $result=$this->noticeData->selectOldThumbNotice($userId);
        echo json_encode($result);
    }

    public function getOldCommentNotice(){
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        $result=$this->noticeData->selectOldCommentNotice($userId);
        echo json_encode($result);
    }

    public function setAllIsReadTrue(){
        if (isset($_POST['noticeIdArray'])) {
            $noticeIdArray = $_POST['noticeIdArray'];
        }
        $result=$this->noticeData->setIsReadTrue($noticeIdArray);
        echo json_encode($result);
    }

    public function doShareThumb()
    {
        if (isset($_POST['startUserId'])) {
            $startUserId = $_POST['startUserId'];
        }
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        if (isset($_POST['shareId'])) {
            $shareId = $_POST['shareId'];
        }

        $result = $this->noticeData->insertShareThumb($startUserId,$userId, $shareId);
    }

    public function cancelShareThumb()
    {
        if (isset($_POST['startUserId'])) {
            $startUserId = $_POST['startUserId'];
        }
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        if (isset($_POST['shareId'])) {
            $shareId = $_POST['shareId'];
        }

        $result = $this->noticeData->cancelShareThumb($startUserId,$userId, $shareId);
    }

    public function addShareComment(){
        if (isset($_POST['startUserId'])) {
            $startUserId=$_POST['startUserId'];
        }
        if (isset($_POST['userId'])) {
            $userId=$_POST['userId'];
        }
        if (isset($_POST['replyShareId'])) {
            $replyShareId = $_POST['replyShareId'];
        }
        if (isset($_POST['replyCommentId'])) {
            $replyCommentId = $_POST['replyCommentId'];
        }
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
        }
        $result=$this->noticeData->insertShareComment($startUserId,$userId,$replyShareId,$replyCommentId,$content);
        echo json_encode($result);

    }

    public function getShareComment(){
        if (isset($_POST['shareId'])) {
            $shareId=$_POST['shareId'];
        }
        $result=$this->noticeData->selectShareCommentByShareId($shareId);

        echo json_encode($result);
    }


    public function addAlbumComment(){
        if (isset($_POST['startUserId'])) {
            $startUserId=$_POST['startUserId'];
        }
        if (isset($_POST['userId'])) {
            $userId=$_POST['userId'];
        }
        if (isset($_POST['replyAlbumId'])) {
            $replyAlbumId = $_POST['replyAlbumId'];
        }
        if (isset($_POST['replyCommentId'])) {
            $replyCommentId = $_POST['replyCommentId'];
        }
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
        }
        $result=$this->noticeData->insertAlbumComment($startUserId,$userId,$replyAlbumId,$replyCommentId,$content);
        echo json_encode($result);

    }


    public function getAlbumComment(){
        if (isset($_POST['albumId'])) {
            $albumId=$_POST['albumId'];
        }
        $result=$this->noticeData->selectAlbumCommentByAlbumId($albumId);

        echo json_encode($result);
    }
}