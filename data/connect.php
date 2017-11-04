<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/10/28
 * Time: 19:24
 */

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open(dirname(__FILE__) . '/../LuckyPie.db');
    }
}
//
//$db = new MyDB();
//if (!$db) {
//    echo $db->lastErrorMsg();
//} else {
////    echo "Opened database successfully\n";
//}
