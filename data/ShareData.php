<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:31
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Share.php');
class ShareData{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    public function insertShareData($share){
        echo "success";
    }
}