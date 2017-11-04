<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:32
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Dating.php');
class DatingData{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertDating($dating){
        return "success";
    }


}