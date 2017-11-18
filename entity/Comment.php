<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/11/18
 * Time: 13:11
 */
class Comment{
    public $id;
    public $userId;
    public $userName;
    public $replyPostId;
    public $replyCommentId;
    public $content;
    public $times;

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getReplyPostId()
    {
        return $this->replyPostId;
    }

    /**
     * @param mixed $replyPostId
     */
    public function setReplyPostId($replyPostId)
    {
        $this->replyPostId = $replyPostId;
    }

    /**
     * @return mixed
     */
    public function getReplyCommentId()
    {
        return $this->replyCommentId;
    }

    /**
     * @param mixed $replyCommentId
     */
    public function setReplyCommentId($replyCommentId)
    {
        $this->replyCommentId = $replyCommentId;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getTimes()
    {
        return $this->times;
    }

    /**
     * @param mixed $times
     */
    public function setTimes($times)
    {
        $this->times = $times;
    }




}