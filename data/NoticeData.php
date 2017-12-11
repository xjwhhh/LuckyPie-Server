<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:32
 */
require_once("connect.php");
require_once("Util.php");
require_once(dirname(__FILE__) . '/../entity/Comment.php');
require_once(dirname(__FILE__) . '/../entity/ResultMessage.php');
require_once(dirname(__FILE__) . '/../entity/Notice.php');

class NoticeData
{
    private $db;

    private $util;

    function __construct()
    {
        $this->db = new MyDB();
        $this->util = new Util();
    }

    /**
     * @param $startUserId
     * @param $userId
     * @param $shareId
     * 插入用户点赞分享的记录
     */
    public function insertShareThumb($startUserId, $userId, $shareId)
    {
        $sql = <<<EOF
insert into thumb (userId,shareId,thumbUserId) values ($startUserId,$shareId,$userId);
EOF;
        $res = $this->db->exec($sql);
        if ($res) {
            $insertNoticeRes = $this->insertNotice($startUserId, $userId, "分享点赞", $shareId, "'分享点赞'");
            if ($insertNoticeRes->getResult() == "success") {
                echo "insertShareThumb Success";
            }
        }
    }

    /**
     * @param $startUserId
     * @param $userId
     * @param $shareId
     * 删除用户点赞分享的记录
     */
    public function cancelShareThumb($startUserId, $userId, $shareId)
    {
        $sql = <<<EOF
update thumb set userId=-1,shareId=-1,thumbUserId=-1 where userId=$startUserId and shareId=$shareId and thumbUserId=$userId;
EOF;
        $res = $this->db->exec($sql);
        if ($res) {
            $deleteNoticeRes = $this->deleteNotice($startUserId, $userId, "分享点赞", $shareId);
            if ($deleteNoticeRes->getResult() == "success") {
                echo "deleteShareThumb Success";
            }
        }
    }

    /**
     * @param $startUserId
     * @param $userId
     * @param $shareId
     * 插入用户@某个用户的记录
     */
    public function insertShareAt($startUserId, $userId, $shareId)
    {
        $sql = <<<EOF
insert into shareAt (userId,shareId,startUserId) values ($userId,$shareId,$startUserId);
EOF;
        $res = $this->db->exec($sql);
        if ($res) {
            $insertNoticeRes = $this->insertNotice($startUserId, $userId, "分享@", $shareId, "'分享@'");
            if ($insertNoticeRes->getResult() == "success") {
                echo "insertShareAt Success";
            }
        }
    }

    /**
     * @param $startUserId
     * @param $userId
     * @param $replyShareId
     * @param $replyCommentId
     * @param $content
     * @return ResultMessage
     * 插入用户对分享的评论记录
     */
    public function insertShareComment($startUserId, $userId, $replyShareId, $replyCommentId, $content)
    {
        $content = $this->util->modifyText($content);
        $resultMessage = new ResultMessage();

        if ($replyCommentId == "") {
            $replyCommentId = -1;
        }
        date_default_timezone_set("Asia/Shanghai");
        $time = date('Y-m-d H:i:s', time());
        $time = "'" . $time . "'";
        $sql = <<<EOF
insert into shareComment (userId,replyShareId,replyCommentId,content,times) values ($startUserId,$replyShareId,$replyCommentId,$content,$time);
EOF;
        $res = $this->db->exec($sql);
        if ($res) {
            $insertNoticeRes = $this->insertNotice($startUserId, $userId, "分享评论", $replyShareId, $content);
            if ($insertNoticeRes->getResult() == "success") {
                $resultMessage->setResult("success");
            }
        } else {
            $resultMessage->setResult("fail");
        }
        return $resultMessage;
    }

    /**
     * @param $shareId
     * @return array
     * 通过分享id获取该分享的所有评论
     */
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
            $userId = $comment->getUserId();
            $userSql = <<<EOF
select name from user where id=$userId;
EOF;
            $res = $this->db->query($userSql);
            while ($userRow = $res->fetchArray(SQLITE3_ASSOC)) {
                $comment->setUserName($userRow['name']);
            }
            array_push($commentArray, $comment);
        }
        return $commentArray;
    }

    /**
     * @param $startUserId
     * @param $userId
     * @param $replyAlbumId
     * @param $replyCommentId
     * @param $content
     * @return ResultMessage
     * 插入用户对相册的评论记录
     */
    public function insertAlbumComment($startUserId, $userId, $replyAlbumId, $replyCommentId, $content)
    {
        $content = $this->util->modifyText($content);
        $resultMessage = new ResultMessage();
        if ($replyCommentId == "") {
            $replyCommentId = -1;
        }
        date_default_timezone_set("Asia/Shanghai");
        $time = date('Y-m-d H:i:s', time());
        $time = "'" . $time . "'";
        $sql = <<<EOF
insert into albumComment (userId,replyAlbumId,replyCommentId,content,times) values ($startUserId,$replyAlbumId,$replyCommentId,$content,$time);
EOF;
        $res = $this->db->exec($sql);
        if ($res) {
            $insertNoticeRes = $this->insertNotice($startUserId, $userId, "相册评论", $replyAlbumId, $content);
            if ($insertNoticeRes->getResult() == "success") {
                $resultMessage->setResult("success");
            }
        } else {
            $resultMessage->setResult("fail");
        }
        return $resultMessage;
    }

    /**
     * @param $albumId
     * @return array
     * 根据相册id获取该相册的所有评论
     */
    public function selectAlbumCommentByAlbumId($albumId)
    {
        $commentArray = array();
        $sql = <<<EOF
select * from albumComment where replyAlbumId=$albumId;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setUserId($row['userId']);
            $comment->setReplyPostId($row['replyAlbumId']);
            $comment->setReplyCommentId($row['replyCommentId']);
            $comment->setContent($row['content']);
            $comment->setTimes($row['times']);
            $userId = $comment->getUserId();
            $userSql = <<<EOF
select name from user where id=$userId;
EOF;
            $res = $this->db->query($userSql);
            while ($userRow = $res->fetchArray(SQLITE3_ASSOC)) {
                $comment->setUserName($userRow['name']);
            }
            array_push($commentArray, $comment);
        }
        return $commentArray;
    }


    /**
     * @param $startUserId
     * @param $userId
     * @param $type
     * @param $postId
     * @param $content
     * @return ResultMessage
     * 插入通知记录
     */
    public function insertNotice($startUserId, $userId, $type, $postId, $content)
    {
        $result = new ResultMessage();
        $isRead = 0;
        $sql = "";
        if ($type == "分享点赞" || $type == "相册点赞" || $type == "分享评论" || $type = "相册评论") {
            $type = $this->util->modifyText($type);
            $sql = <<<EOF
insert into notice (userId,startUserId,type,postId,content,isRead) values($userId,$startUserId,$type,$postId,$content,$isRead);
EOF;
        }
        $res = $this->db->exec($sql);
        if ($res) {
            $result->setResult("success");
        } else {
            $result->setResult("fail");
        }
        return $result;


    }

    /**
     * @param $startUserId
     * @param $userId
     * @param $type
     * @param $postId
     * @return ResultMessage
     * 删除通知记录
     */
    public function deleteNotice($startUserId, $userId, $type, $postId)
    {
        $result = new ResultMessage();
        if ($type == "分享点赞" || $type == "分享评论" || $type == "相册点赞" || $type = "相册评论") {
            $type = $this->util->modifyText($type);
            $sql = <<<EOF
update notice set startUserId=-1 and userId=-1 where startUserId=$startUserId and userId=$userId and type=$type and postId=$postId;
EOF;
        }
        $res = $this->db->exec($sql);
        if ($res) {
            $result->setResult("success");
        } else {
            $result->setResult("fail");
        }
        return $result;
    }

    /**
     * @param $userId
     * @return array
     * 根据用户id获取未读点赞通知
     */
    public function selectNewThumbNotice($userId)
    {
        $noticeArray = array();
        $sql = <<<EOF
select * from notice where userId=$userId and type like '%点赞' and isRead=0;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice = new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray, $notice);
        }
        return $noticeArray;
    }

    /**
     * @param $userId
     * @return array
     * 根据用户id获取未读评论通知
     */
    public function selectNewCommentNotice($userId)
    {
        $noticeArray = array();
        $sql = <<<EOF
select * from notice where userId=$userId and type like '%评论' and isRead=0;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice = new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray, $notice);
        }
        return $noticeArray;
    }

    /**
     * @param $userId
     * @return array
     * 根据用户id获取已读点赞通知
     */
    public function selectOldThumbNotice($userId)
    {
        $noticeArray = array();
        $sql = <<<EOF
select * from notice where userId=$userId and type like '%点赞' and isRead=1;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice = new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray, $notice);
        }
        return $noticeArray;
    }

    /**
     * @param $userId
     * @return array
     * 根据用户id获取已读评论通知
     */
    public function selectOldCommentNotice($userId)
    {
        $noticeArray = array();
        $sql = <<<EOF
select * from notice where userId=$userId and type like '%评论' and isRead=1;
EOF;
        $result = $this->db->query($sql);
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $notice = new Notice();
            $notice->setId($row['id']);
            $notice->setUserId($row['userId']);
            $notice->setStartUserId($row['startUserId']);
            $notice->setType($row['type']);
            $notice->setPostId($row['postId']);
            $notice->setContent($row['content']);
            array_push($noticeArray, $notice);
        }
        return $noticeArray;
    }

    /**
     * @param $noticeIdArray
     * @return ResultMessage
     * 根据通知id将未读通知设为已读
     */
    public function setIsReadTrue($noticeIdArray)
    {
        $noticeIdArray = explode(',', $noticeIdArray);
        foreach ($noticeIdArray as $noticeId) {
            $sql = <<<EOF
update notice set isRead=1 where id=$noticeId;
EOF;
            $res = $this->db->exec($sql);
        }
        $result = new ResultMessage();
        $result->setResult("success");
        return $result;
    }


}