<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 22:14
 */
require_once ("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../entity/User.php');
require_once(dirname(__FILE__) . '/../entity/UserBasicInfo.php');

class UserHandler extends SimpleHandler{

    public function getUserInfo($id){
        $user = new User();
        $user->setAlbums("2345");
        $user->setShares("2345");
        $user->setLikes("2345");
        $userBasic=new UserBasicInfo();
        $userBasic->setAccount("1");
        $userBasic->setId("1");
        $user->setBasicInfo($userBasic);

        echo json_encode($user);
    }

    public function updateUserInfo(){

    }




}