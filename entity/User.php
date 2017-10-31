<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 19:21
 */

Class User
{

    public $basicInfo;
    public $follows;
    public $followers;
    public $likes="";
    public $dates="";
    public $shares="";
    public $albums="";


    /**
     * @return mixed
     */
    public function getBasicInfo()
    {
        return $this->basicInfo;
    }

    /**
     * @param mixed $basicInfo
     */
    public function setBasicInfo($basicInfo)
    {
        $this->basicInfo = $basicInfo;
    }

    /**
     * @return mixed
     */
    public function getFollows()
    {
        return $this->follows;
    }

    /**
     * @param mixed $follows
     */
    public function setFollows($follows)
    {
        $this->follows = $follows;
    }

    /**
     * @return mixed
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param mixed $followers
     */
    public function setFollowers($followers)
    {
        $this->followers = $followers;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return mixed
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param mixed $dates
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
    }

    /**
     * @return mixed
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * @param mixed $shares
     */
    public function setShares($shares)
    {
        $this->shares = $shares;
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }

}

