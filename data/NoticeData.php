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

class NoticeData
{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertShareComment($userId, $replyShareId, $replyCommentId, $content)
    {
        $content = "'" . $content . "'";
//        $returnComment=new Comment();
        $resultMessage = new ResultMessage();

        if ($replyCommentId == "") {
            $replyCommentId = -1;
        }
        $time=date('Y-m-d H:i:s', time());
        $time="'".$time."'";
        $sql = <<<EOF
insert into shareComment (userId,replyShareId,replyCommentId,content,times) values ($userId,$replyShareId,$replyCommentId,$content,$time);
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
            $resultMessage->setResult("success");


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
}