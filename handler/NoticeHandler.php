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
    public function getNotice(){


    }

    public function addNotice(){

    }

    public function deleteNotice(){

    }

    public function addShareComment(){
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
        $result=$this->noticeData->insertShareComment($userId,$replyShareId,$replyCommentId,$content);
        echo json_encode($result);

    }

    public function getShareComment(){
        if (isset($_POST['shareId'])) {
            $shareId=$_POST['shareId'];
        }
        $result=$this->noticeData->selectShareCommentByShareId($shareId);

        echo json_encode($result);
    }
}