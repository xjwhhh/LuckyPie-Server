<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 22:35
 */
require_once("connect.php");

$db = new MyDB();
if (!$db) {
    echo $db->lastErrorMsg();
} else {
    echo "Opened database successfully\n";
}

//create table user
//$sql= <<<EOF
//      CREATE TABLE user
//      (id INTEGER PRIMARY KEY autoincrement,
//      account VARCHAR(255)   NOT NULL,
//      password VARCHAR(255)    NOT NULL,
//      name VARCHAR(255),
//      head VARCHAR(255),
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
//      title varchar(255) not null,
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
//      url varchar(255) not null
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

////create table datingPhoto
//$sql= <<<EOF
//      CREATE TABLE datingPhoto
//      (photoId int not null,
//      datingId int not null
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

//create table thumb
//$sql= <<<EOF
//      CREATE TABLE thumb
//      (userId int not null,
//      shareId int not null,
//      thumbUserId int not null
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

//create table comment
//$sql= <<<EOF
//      CREATE TABLE shareComment
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int not null,
//      replyShareId int not null,
//      replyCommentId int not null,
//      content text,
//      times varchar(255) not null
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


//create table comment
//$sql= <<<EOF
//      CREATE TABLE albumComment
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int not null,
//      replyAlbumId int not null,
//      replyCommentId int not null,
//      content text,
//      times varchar(255) not null
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
//      type varchar(255) not null
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
//
////create table datingTag
//$sql= <<<EOF
//      CREATE TABLE datingTag
//      (tagId int not null,
//      datingId int not null
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


//$array=array("情侣", "商务", "民国", "汉服", "孕照", "儿童", "暗黑", "情绪", "私房", "夜景", "校园", "妆容", "古风", "淘宝", "时尚", "和服", "旗袍", "韩系", "欧美", "森系", "少女", "清新", "婚礼", "cos", "胶片", "黑白", "纪实", "日系");
//foreach ($array as $tag) {
//    $tag="'".$tag."'";
//    $sql = <<<EOF
//      INSERT INTO tag (type)
//      VALUES ($tag );
//EOF;
//
//    $ret = $db->exec($sql);
//    if (!$ret) {
//        echo $db->lastErrorMsg();
//    } else {
//        echo "Records created successfully\n";
//    }
//}
//$db->close();
//$sql = <<<EOF
//      SELECT * from tag;
//EOF;
//
//$ret = $db->query($sql);
//while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
//    echo "ID = " . $row['id'] . "\n";
//    echo "type = " . $row['type'] . "\n";
//}
//echo "Operation done successfully\n";
//$db->close();
//
//$sql = <<<EOF
//      INSERT INTO share (userId)
//      VALUES (100);
//
//       INSERT INTO share (userId)
//      VALUES (100);
//
// INSERT INTO share (userId)
//      VALUES (100);
//EOF;
//
//$ret = $db->exec($sql);
//if (!$ret) {
//    echo $db->lastErrorMsg();
//} else {
//    echo "Records created successfully\n";
//}


//$sql = <<<EOF
//      SELECT * from user;
//EOF;
//
//$ret = $db->query($sql);
//while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
////    echo "userID = " . $row['userId'] . "\n";
//    echo "shareID = " . $row['id'] . "\n";
//    echo "account= " . $row['account'] . "\n";
//    echo "password = " . $row['password'] . "\n";
////    echo "time = " . $row['uploadTime'] . "\n";
////    echo "url = " . $row['url'] . "\n";
//}
//echo "Operation done successfully\n";
////todo 数据库记录消失
//$db->close();


//$sql = <<<EOF
//      SELECT * from share;
//EOF;
//
//$ret = $db->query($sql);
//print_r($ret);
//while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
//    echo "erty";
//    echo "ID = " . $row['id'] . "\n";
//    echo "account = " . $row['postTime'] . "\n";
//    echo "password = " . $row['description'] . "\n";
//}
//echo "Operation done successfully\n";
//
//$db->close();

////create table notice
//$sql = <<<EOF
//      CREATE TABLE notice
//      (id INTEGER PRIMARY KEY autoincrement,
//      userId int   NOT NULL,
//      startUserId int   NOT NULL,
//      postId int ,
//      type varchar(255),
//      content text,
//      isRead int
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

////create table shareAt
//$sql= <<<EOF
//      CREATE TABLE shareAt
//      (userId int not null,
//      shareId int not null,
//      startUserId int not null
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