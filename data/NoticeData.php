<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:32
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Comment.php');
require_once(dirname(__FILE__) . '/../entity/ResultMessage.php');
require_once(dirname(__FILE__) . '/../entity/Notice.php');

class NoticeData
{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertShareThumb($startUserId,$userId, $shareId)
    {
        $sql = <<<EOF
insert into thumb (userId,shareId) values ($startUserId,$shareId);
EOF;
        $res = $this->db->exec($sql);
        if($res) {
            $insertNoticeRes=$this->insertNotice($startUserId,$userId,"分享点赞",$shareId,"'分享点赞'");
            if($insertNoticeRes->getResult()=="success"){
                echo "insertShareThumb Success";
            }
        }
    }

    public function cancelShareThumb($startUserId,$userId, $shareId)
    {
        $sql = <<<EOF
update thumb set userId=-1,shareId=-1 where userId=$startUserId and shareId=$shareId;
EOF;
        $res = $this->db->exec($sql);
        if ($res) {
            $deleteNoticeRes=$this->deleteNotice($startUserId,$userId,"分享点赞",$shareId);
            if($deleteNoticeRes->getResult()=="success"){
                echo "deleteShareThumb Success";
            }
        }
    }

    public function insertShareComment($startUserId,$userId, $replyShareId, $replyCommentId, $content)
    {
        $content = $this->modifyText($content);
//        $returnComment=new Comment();
        $resultMessage = new ResultMessage();

        if ($replyCommentId == "") {
            $replyCommentId = -1;
        }
        date_default_timezone_set("Asia/Shanghai");
        $time=date('Y-m-d H:i:s', time());
        $time="'".$time."'";
        $sql = <<<EOF
insert into shareComment (userId,replyShareId,replyCommentId,content,times) values ($startUserId,$replyShareId,$replyCommentId,$content,$time);
EOF;
//        }
//        else{
//            $replyShareId=-1;
//            $sql=<<<EOF
//insert into shareComment (userId,replyShareId,replyCommentId,content) values ($userId,$replyShareId,$replyCommentId,$content);
//EOF;
//        }
        $res = $this->db->exec($sql);
        if ($res) {
//            $sql=<<<EOF
//select * from shareComment where userId=$userId and replyShareId=$replyShareId and replyCommentId=$replyCommentId;
//EOF;
//            $result=$this->db->query($sql);
//            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
//$returnComment->setId($row['id']);
//$returnComment->setUserId($row['userId']);
//
//
//            }
            $insertNoticeRes=$this->insertNotice($startUserId,$userId,"分享评论",$replyShareId,$content);
            if($insertNoticeRes->getResult()=="success"){
                $resultMessage->setResult("success");
            }




        } else {
            $resultMessage->setResult("fail");
        }
        return $resultMessage;
//        return  $returnComment;

    }

    public function selectShareCommentByShareId($shareId)
    {
        $commentArray = array();
        $sql = <<<EOF
select * from shareComment where replyShareId=$shareId;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setUserId($row['userId']);
            $comment->setReplyPostId($row['replyShareId']);
            $comment->setReplyCommentId($row['replyCommentId']);
            $comment->setContent($row['content']);
            $comment->setTimes($row['times']);

            $userId=$comment->getUserId();

            $userSql=<<<EOF
select name from user where id=$userId;
EOF;
            $res=$this->db->query($userSql);
            while($userRow = $res->fetchArray(SQLITE3_ASSOC)){
                $comment->setUserName($userRow['name']);
            }


            array_push($commentArray,$comment);
        }

        return $commentArray;


    }


    public function insertNotice($startUserId,$userId,$type,$postId,$content){
        $result=new ResultMessage();
        $isRead=0;
        $sql="";
        if($type=="分享点赞"||$type=="相册点赞"||$type=="分享评论"||$type="相册评论"){
        $type=$this->modifyText($type);
            $sql=<<<EOF
insert into notice (userId,startUserId,type,postId,content,isRead) values($userId,$startUserId,$type,$postId,$content,$isRead);
EOF;
        }
        $res = $this->db->exec($sql);
        if($res){
            $result->setResult("success");
        }else{
            $result->setResult("fail");
        }
        return $result;


    }

    public function deleteNotice($startUserId,$userId,$type,$postId){
        $result=new ResultMessage();
        if($type=="分享点赞"||$type=="分享评论"||$type=="相册点赞"||$type="相册评论"){
            $type=$this->modifyText($type);
            $sql=<<<EOF
update notice set startUserId=-1 and userId=-1 where startUserId=$startUserId and userId=$userId and type=$type and postId=$postId;
EOF;
        }
        else {
            echo "345678";
        }
        $res = $this->db->exec($sql);
        if($res){
            $result->setResult("success");
        }else{
            $result->setResult("fail");
        }
        return $result;
    }




    public function selectNewThumbNotice($userId){
        $noticeArray=array();
        $sql=<<<EOF
select * from notice where userId=$userId and type like '%点赞' and isRead=0;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice=new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray,$notice);
        }
        return $noticeArray;
    }

    public function selectNewCommentNotice($userId){
        $noticeArray=array();
        $sql=<<<EOF
select * from notice where userId=$userId and type like '%评论' and isRead=0;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice=new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray,$notice);
        }
        return $noticeArray;
    }

    public function selectOldThumbNotice($userId){
        $noticeArray=array();
        $sql=<<<EOF
select * from notice where userId=$userId and type like '%点赞' and isRead=1;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice=new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray,$notice);
        }
        return $noticeArray;
    }

    public function selectOldCommentNotice($userId){
        $noticeArray=array();
        $sql=<<<EOF
select * from notice where userId=$userId and type like '%评论' and isRead=1;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice=new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray,$notice);
        }
        return $noticeArray;
    }

    public function setIsReadTrue($noticeIdArray){
//        $isArray=strpos($noticeIdArray,",");
//        echo $isArray;
        $noticeIdArray=explode(',',$noticeIdArray);
//        foreach ($noticeIdArray as $noticeId){
//            $sql=<<<EOF
//update notice set isRead=1 where id=$noticeId;
//EOF;
//            $res=$this->db->exec($sql);
////            echo $noticeId;
//        }
//        return
        $result=new ResultMessage();
        $result->setResult("success");
        return $result;
    }



    private function modifyText($text){
        return "'".$text."'";
}
}