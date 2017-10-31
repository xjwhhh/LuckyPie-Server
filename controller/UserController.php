<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/10/31
 * Time: 20:41
 */
require_once (dirname(__FILE__) . '/../handler/UserHandler.php');


//获取http的request方法
$method = strtolower($_SERVER['REQUEST_METHOD']);
echo $method;

$userHandler=new UserHandler();
$userHandler->getUserInfo("1");






