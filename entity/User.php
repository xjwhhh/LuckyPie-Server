<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/31
 * Time: 19:21
 */

Class User
{

    public $id;
    public $account;
    public $password;
    public $name;
    public $head;
    public $authority;
    public $introduction;
    public $identity;
    public $gender;
    public $telephone;
    public $email;
    public $follows;
    public $followers;
    public $likes;
    public $dates;
    public $shares;
    public $albums;

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
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param mixed $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }



    /**
     * @return mixed
     */
    public function getAuthority()
    {
        return $this->authority;
    }

    /**
     * @param mixed $authority
     */
    public function setAuthority($authority)
    {
        $this->authority = $authority;
    }

    /**
     * @return mixed
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * @param mixed $introduction
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param mixed $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return string
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param string $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return string
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param string $dates
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
    }

    /**
     * @return string
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * @param string $shares
     */
    public function setShares($shares)
    {
        $this->shares = $shares;
    }

    /**
     * @return string
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param string $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }


}

