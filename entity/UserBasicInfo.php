<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 19:30
 */

class UserBasicInfo{
    private $id;
    private $account;
    private $password;
    private $name;
    private $identity;
    private $gender;
    private $telephone;
    private $email;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getAccount(){
        return $this->account;
    }

    public function setAccount($account){
        $this->account=$account;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password=$password;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getIdentity(){
        return $this->identity;
    }

    public function setIdentity($identity){
        $this->identity=$identity;
    }

    public function getGender(){
        return $this->gender;
    }

    public function setGender($gender){
        $this->gender=$gender;
    }

    public function getTelephone(){
        return $this->telephone;
    }

    public function setTelephone($telephone){
        $this->telephone=$telephone;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email=$email;
    }
}