<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/11/1
 * Time: 22:35
 */
require_once ("connect.php");

$db = new MyDB();
if (!$db) {
    echo $db->lastErrorMsg();
} else {
    echo "Opened database successfully\n";
}

////create table user
//$sql= <<<EOF
//      CREATE TABLE user
//      (id INTEGER PRIMARY KEY autoincrement,
//      account VARCHAR(255)   NOT NULL,
//      password VARCHAR(255)    NOT NULL,
//      name VARCHAR(255),
//      authority int not null,
//      introduction text,
//      identity varchar(255),
//      gender varchar(255),
//      telephone VARCHAR (255),
//      email VARCHAR (255)
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Table created successfully\n";
//}
//$db->close();

//$sql = <<<EOF
//      INSERT INTO USER (account,password,authority)
//      VALUES ('1','1',1);
//
//      INSERT INTO USER (account,password,authority)
//      VALUES ('2','2',0);
//      INSERT INTO USER (account,password,authority)
//      VALUES ('3','3',0);
//      INSERT INTO USER (account,password,authority)
//      VALUES ('4','4',0);
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();


//create table album
//$sql= <<<EOF
//      CREATE TABLE album
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int   NOT NULL,
//      name varchar(255) not null,
//      description text
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Table created successfully\n";
//}
//$db->close();