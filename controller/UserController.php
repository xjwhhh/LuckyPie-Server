<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/31
 * Time: 20:41
 */
require_once (dirname(__FILE__) . '/../handler/UserHandler.php');
$option = "";
if(isset($_GET["option"]))
    $option = $_GET["option"];
if(isset($_POST["option"]))
    $option = $_POST["option"];

switch ($option){
    case "login":
        $userHandler=new UserHandler();
        $userHandler->login();
        break;

    case "register":
        $userHandler=new UserHandler();
        $userHandler->register();
        break;

    case "getInfo":
        $userHandler=new UserHandler();
        $userHandler->getUserInfo();
        break;

    case "updateInfo":
        $userHandler=new UserHandler();
        $userHandler->updateUserInfo();
        break;
}






