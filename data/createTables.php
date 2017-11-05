<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
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
//      description text,
//      createTime varchar(255),
//      updateTime varchar(255)
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

//create table dating
//$sql= <<<EOF
//      CREATE TABLE dating
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int   NOT NULL,
//      description text,
//      cost varchar(255),
//      photoAddress varchar(255),
//      photoTime varchar(255),
//      postAddress varchar(255),
//      postTime varchar(255)
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

//create table share
//$sql= <<<EOF
//      CREATE TABLE share
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int   NOT NULL,
//      description text,
//      postAddress varchar(255),
//      postTime varchar(255),
//      forwardShareId int
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

//create table photo
//$sql= <<<EOF
//      CREATE TABLE photo
//      (id INTEGER PRIMARY KEY autoincrement,
//      uploadTime varchar(255) not null,
//      url text not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table datePhoto
//$sql= <<<EOF
//      CREATE TABLE datePhoto
//      (photoId int not null,
//      dateId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table albumPhoto
//$sql= <<<EOF
//      CREATE TABLE albumPhoto
//      (photoId int not null,
//      albumId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table sharePhoto
//$sql= <<<EOF
//      CREATE TABLE sharePhoto
//      (photoId int not null,
//      shareId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

//create table follow
//$sql= <<<EOF
//      CREATE TABLE follow
//      (followId int not null,
//      followerId int not null,
//      groupId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table followGroup
//$sql= <<<EOF
//      CREATE TABLE followGroup
//      (groupId int not null,
//      userId int not null,
//      groupName varchar(255) not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table thumb
//$sql= <<<EOF
//      CREATE TABLE thumb
//      (userId int not null,
//      shareId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table comment
//$sql= <<<EOF
//      CREATE TABLE comment
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int not null,
//      replyShareId int not null,
//      replyCommentId int not null,
//      content text
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table tag
//$sql= <<<EOF
//      CREATE TABLE tag
//      (id INTEGER PRIMARY KEY autoincrement,
//      name varchar(255) not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table shareTag
//$sql= <<<EOF
//      CREATE TABLE shareTag
//      (tagId int not null,
//      shareId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table dateTag
//$sql= <<<EOF
//      CREATE TABLE dateTag
//      (tagId int not null,
//      dateId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();

////create table albumTag
//$sql= <<<EOF
//      CREATE TABLE albumTag
//      (tagId int not null,
//      albumId int not null
//      );
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}
//$db->close();