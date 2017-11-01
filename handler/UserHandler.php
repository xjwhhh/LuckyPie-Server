<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 22:14
 */
require_once ("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../entity/User.php');

class UserHandler extends SimpleHandler{

    //post:account,password
    public function login(){
//        print_r($_SERVER) ;
//       print_r( $_REQUEST);

    }

    //post:account,password,ensurePassword
    public function register(){

    }

    //get:id
    public function getUserInfo($id){
        $user = new User();
        $user->setAlbums("2345");
        $user->setShares("2345");
        $user->setLikes("2345");
        $user->setAccount("1");
        $user->setId("1");

        echo json_encode($user);
    }

    public function updateUserInfo(){

    }

    public function getExplorePhotographer(){

    }

    public function getExploreModel(){

    }




}