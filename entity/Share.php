<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 20:18
 */

class Share{
    public $id;
    public $userId;
    public $desc;
    public $imageUrls;
    public $numOfLikes;
    public $numOfForwards;
    public $numOfComments;
    public $comments;
    public $postTime;
    public $postAddress;

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
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getImageUrls()
    {
        return $this->imageUrls;
    }

    /**
     * @param mixed $imageUrls
     */
    public function setImageUrls($imageUrls)
    {
        $this->imageUrls = $imageUrls;
    }

    /**
     * @return mixed
     */
    public function getNumOfLikes()
    {
        return $this->numOfLikes;
    }

    /**
     * @param mixed $numOfLikes
     */
    public function setNumOfLikes($numOfLikes)
    {
        $this->numOfLikes = $numOfLikes;
    }

    /**
     * @return mixed
     */
    public function getNumOfForwards()
    {
        return $this->numOfForwards;
    }

    /**
     * @param mixed $numOfForwards
     */
    public function setNumOfForwards($numOfForwards)
    {
        $this->numOfForwards = $numOfForwards;
    }

    /**
     * @return mixed
     */
    public function getNumOfComments()
    {
        return $this->numOfComments;
    }

    /**
     * @param mixed $numOfComments
     */
    public function setNumOfComments($numOfComments)
    {
        $this->numOfComments = $numOfComments;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getPostTime()
    {
        return $this->postTime;
    }

    /**
     * @param mixed $postTime
     */
    public function setPostTime($postTime)
    {
        $this->postTime = $postTime;
    }

    /**
     * @return mixed
     */
    public function getPostAddress()
    {
        return $this->postAddress;
    }

    /**
     * @param mixed $postAddress
     */
    public function setPostAddress($postAddress)
    {
        $this->postAddress = $postAddress;
    }


}