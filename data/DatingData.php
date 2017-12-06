<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/3
 * Time: 18:32
 */
require_once("connect.php");
require_once(dirname(__FILE__) . '/../entity/Dating.php');

class DatingData
{
    private $db;

    function __construct()
    {
        $this->db = new MyDB();
    }

    //对dating的操作涉及三个表,dating,datingPhoto,datingTag

    private function getDatingImagesAndTags($dating){
//        echo "ety";
        $datingId=$dating->getId();
        //获取photo
        $photoArray = array();
        $photoSql = <<<EOF
      SELECT photo.url from datingPhoto,photo where datingPhoto.datingId=$datingId and photo.id=datingPhoto.photoId;
EOF;
        $photoRes = $this->db->query($photoSql);
        while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
            array_push($photoArray, $photoRow['url']);
        }
        $dating->setImageUrls($photoArray);
        //获取tag todo 不匹配
        $tagArray = array();
        $tagSql = <<<EOF
      SELECT tag.type from datingTag,tag where datingTag.datingId=$datingId and tag.id=datingTag.tagId;
EOF;
        $tagRes = $this->db->query($tagSql);
        while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
            array_push($tagArray, $tagRow['type']);
        }
//        print_r($tagArray);
        $dating->setTags($tagArray);
        return $dating;
    }

    public function insertDating($dating)
    {

        $returnDating = new Dating();
        $userId = $dating->getUserId();
        $description = $dating->getDesc();
        $cost = $dating->getCost();
        $photoTime = $dating->getPhotoTime();
        $photoAddress = $dating->getPhotoAddress();
        $postTime = $dating->getPostTime();
        $postAddress = $dating->getPostAddress();
        $photoArray = $dating->getImageUrls();
        $tagArray = $dating->getTags();

//        echo $photoTime;


        $description = "'" . $description . "'";
        $postTime = "'" . $postTime . "'";
        $cost = "'" . $cost . "'";
        $photoAddress = "'" . $photoAddress . "'";
        $postAddress = "'" . $postAddress . "'";
        //插入dating
        $sql = <<<EOF
      INSERT INTO dating (userId,description,cost,photoTime,photoAddress,postTime,postAddress)
      VALUES ($userId,$description,$cost,$photoTime,$photoAddress,$postTime,$postAddress);
EOF;
        $ret = $this->db->exec($sql);
        //插入dating成功
        if ($ret) {
            $sql = <<<EOF
      SELECT * from dating where userId=$userId and postTime=$postTime;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $returnDating->setId($row['id']);
                $returnDating->setUserId($row['userId']);
                $returnDating->setDesc($row['description']);
                $returnDating->setCost($row['cost']);
                $returnDating->setPhotoTime($row['photoTime']);
                $returnDating->setPhotoAddress($row['photoAddress']);
                $returnDating->setPostTime($row['postTime']);
                $returnDating->setPostAddress($row['postAddress']);
            }
        }
//        echo $returnDating->getPhotoTime();

        $datingId = $returnDating->getId();

        $urlArray = array();//返回的imageURL
        //插入sharePhoto
        $diff = 0;
        foreach ($photoArray as $base64Code) {
            $photoId = 0;
            //不查看照片是否已经上传过
            //上传至服务器
            preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Code, $result);
            $type = $result[2];
            $catalog = date('Ymd', time()) . "/";
            $new_file = "C:/Apache24/htdocs/LuckyPie-Server/photo/" . $catalog;
            $http_file = "http://localhost/LuckyPie-Server/photo/" . $catalog;
            if (!file_exists($new_file)) {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $time = time();
            $new_file = $new_file . $time . $diff . ".{$type}";
            $http_file = $http_file . $time . $diff . ".{$type}";
            $diff = $diff + 1;
            $base64Code = str_replace(" ", "+", $base64Code);
            $tt = str_replace($result[1], '', $base64Code);
            $ll = base64_decode($tt);
            file_put_contents($new_file, $ll);
            $now = date("Y-m-d H:i:s.u", time());
            $now = "'" . $now . "'";
            $http_file = "'" . $http_file . "'";
            $photoSql = <<<EOF
insert into photo (uploadTime,url) values($now,$http_file);
EOF;
            $photoRes = $this->db->exec($photoSql);
            //插入photo成功
            if ($photoRes) {
                $photoSql = <<<EOF
select * from photo where uploadTime=$now and url=$http_file;
EOF;
                $photoRes = $this->db->query($photoSql);
                //返回图片在服务器存储的位置
                while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                    $photoId = $photoRow['id'];
                    array_push($urlArray, $photoRow['url']);
                }
            } else {
                return new Dating();
            }
            //获得photoId插入sharePhoto

            $datingPhotoSql = <<<EOF
insert into datingPhoto (photoId,datingId) values ($photoId,$datingId);
EOF;
            $datingPhotoRes = $this->db->exec($datingPhotoSql);
            if (!$datingPhotoRes) {
                return new Dating();
            }
        }
        $returnDating->setImageUrls($urlArray);

        //插入datingTag
        foreach ($tagArray as $tag) {
            $tag = "'" . $tag . "'";
            $tagId = -1;
            $tagSql = <<<EOF
select id from tag where type=$tag;
EOF;
            $tagRes = $this->db->query($tagSql);
            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                $tagId = $tagRow['id'];
            }
//            echo $tagId;
            $datingTagSql = <<<EOF
insert into datingTag values ($datingId,$tagId);
EOF;
            $datingTagRes = $this->db > exec($datingTagSql);
            if (!$datingTagRes) {
                return new Dating();
            }

        }

        $returnDating->setTags($tagArray);
//        $returnDating=$this->getDatingImagesAndTags($returnDating);

        return $returnDating;


    }

    public function updateDating()
    {

    }

    public function deleteDating($datingId)
    {
        $sql = <<<EOF
      DELETE from dating where id=$datingId;
      DELETE from datingPhoto where datingId=$datingId;
      DELETE from datingTag where datingId=$datingId;
EOF;
        $ret = $this->db->exec($sql);
        if (!$ret) {
            return "fail";
        } else {
            return "success";
        }
    }

    public function selectDatingDataByUserId($userId)
    {
        $datingArray = array();
        $sql = <<<EOF
      SELECT * from dating where userId=$userId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $dating = new Dating();
            $dating->setId($row['id']);
            $dating->setUserId($row['userId']);
            $dating->setDesc($row['description']);
            $dating->setCost($row['cost']);
            $dating->setPhotoTime($row['photoTime']);
            $dating->setPostTime($row['postTime']);
            $dating->setPhotoAddress($row['photoAddress']);
            $dating->setPostAddress($row['postAddress']);

//            $datingId=$dating->getId();
//            //获取photo
//            $photoArray = array();
//            $photoSql = <<<EOF
//      SELECT photo.url from datingPhoto,photo where datingPhoto.datingId=$datingId and photo.id=datingPhoto.photoId;
//EOF;
//            $photoRes = $this->db->query($photoSql);
//            while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
//                array_push($photoArray, $photoRow['url']);
//            }
//            $dating->setImageUrls($photoArray);
//            //获取tag
//            $tagArray = array();
//            $tagSql = <<<EOF
//      SELECT tag.type from datingTag,tag where datingTag.datingId=$datingId and tag.id=datingTag.tagId;
//EOF;
//            $tagRes = $this->db->query($tagSql);
//            while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
//                array_push($tagArray, $tagRow['type']);
//            }
//            $dating->setTags($tagArray);
            $dating=$this->getDatingImagesAndTags($dating);

            array_push($datingArray, $dating);
        }
        return $datingArray;

    }

    //可能不需要
    public function selectHotDating()
    {

    }

    public function selectExploreDatingByConditions($address, $cost, $identity, $gender)
    {
        $datingArrayAddress = array();
        $datingArrayCost = array();
        $datingArrayIdentity = array();
        $datingArrayGender = array();

        //按地点筛选
        if ($address != "全部") {
            $address = "'" . $address . "'";
            $sql = <<<EOF
select * from dating where photoAddress=$address;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $dating = new Dating();
                $dating->setId($row['id']);
                $dating->setUserId($row['userId']);
                $dating->setDesc($row['description']);
                $dating->setCost($row['cost']);
                $dating->setPhotoTime($row['photoTime']);
                $dating->setPostTime($row['postTime']);
                $dating->setPhotoAddress($row['photoAddress']);
                $dating->setPostAddress($row['postAddress']);

                $datingId=$dating->getId();
                //获取photo
                $photoArray = array();
                $photoSql = <<<EOF
      SELECT photo.url from datingPhoto,photo where datingPhoto.datingId=$datingId and photo.id=datingPhoto.photoId;
EOF;
                $photoRes = $this->db->query($photoSql);
                while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                    array_push($photoArray, $photoRow['url']);
                }
                $dating->setImageUrls($photoArray);
                //获取tag todo 不匹配
                $tagArray = array();
                $tagSql = <<<EOF
      SELECT tag.type from datingTag,tag where datingTag.datingId=$datingId and tag.id=datingTag.tagId;
EOF;
                $tagRes = $this->db->query($tagSql);
                while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                    array_push($tagArray, $tagRow['type']);
                }
                $dating->setTags($tagArray);

                array_push($datingArrayAddress, $dating);
            }
        } else {
            $address = "'" . $address . "'";
            $sql = <<<EOF
select * from dating;
EOF;
            $res = $this->db->query($sql);
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                $dating = new Dating();
                $dating->setId($row['id']);
                $dating->setUserId($row['userId']);
                $dating->setDesc($row['description']);
                $dating->setCost($row['cost']);
                $dating->setPhotoTime($row['photoTime']);
                $dating->setPostTime($row['postTime']);
                $dating->setPhotoAddress($row['photoAddress']);
                $dating->setPostAddress($row['postAddress']);

                $datingId=$dating->getId();
                //获取photo
                $photoArray = array();
                $photoSql = <<<EOF
      SELECT photo.url from datingPhoto,photo where datingPhoto.datingId=$datingId and photo.id=datingPhoto.photoId;
EOF;
                $photoRes = $this->db->query($photoSql);
                while ($photoRow = $photoRes->fetchArray(SQLITE3_ASSOC)) {
                    array_push($photoArray, $photoRow['url']);
                }
                $dating->setImageUrls($photoArray);
                //获取tag todo 不匹配
                $tagArray = array();
                $tagSql = <<<EOF
      SELECT tag.type from datingTag,tag where datingTag.datingId=$datingId and tag.id=datingTag.tagId;
EOF;
                $tagRes = $this->db->query($tagSql);
                while ($tagRow = $tagRes->fetchArray(SQLITE3_ASSOC)) {
                    array_push($tagArray, $tagRow['type']);
                }
                $dating->setTags($tagArray);

                array_push($datingArrayAddress, $dating);
            }
        }

        //按价格筛选
        if ($cost != "全部") {
            foreach ($datingArrayAddress as $dating) {
                if ($dating->getCost() == $cost) {
                    array_push($datingArrayCost, $dating);
                }
            }
        } else {
            $datingArrayCost = $datingArrayAddress;
        }
        //按身份筛选
        if ($identity != "无") {
            foreach ($datingArrayCost as $dating) {
                $userId = $dating->getUserId();
                $sql = <<<EOF
select identity from user where id=$userId;
EOF;
                $ret = $this->db->query($sql);
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    if ($row['identity'] == $identity) {
                        array_push($datingArrayIdentity, $dating);
                    }
                }
            }
        } else {
            $datingArrayIdentity = $datingArrayCost;
        }
        //按性别筛选
        if ($gender != "无") {
            foreach ($datingArrayIdentity as $dating) {
                $userId = $dating->getUserId();
                $sql = <<<EOF
select gender from user where id=$userId;
EOF;
                $ret = $this->db->query($sql);
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    if ($row['gender'] == $gender) {
                        array_push($datingArrayGender, $dating);
                    }
                }
            }
        } else {
            $datingArrayGender = $datingArrayIdentity;
        }

        return $datingArrayGender;
    }


    public function selectFollowingDatingByUserId($userId, $groupName)
    {
        //获取分组关注
        $followIdArray = array();
        $sql = <<<EOF
      SELECT f.followId from follow f,followGroup fg where fg.userId=$userId and fg.groupName=$groupName and f.gruopId=fg.groupId;
EOF;
        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            array_push($followIdArray, $row['followId']);
        }
        //获取关注用户的约拍
        $shareArray = array();
        foreach ($followIdArray as $followId) {
            $result = $this->selectDatingDataByUserId($followId);
            $shareArray = array_merge_recursive($shareArray, $result);
        }
        return $shareArray;
        //todo 按时间排序


    }

    public function selectDatingBySearch($content)
    {
        $content = "%" . $content . "%";
        $content = "'" . $content . "'";
        $datingArray = array();
        $sql = <<<EOF
select * from dating where description like $content;
EOF;

        $res = $this->db->query($sql);
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $dating = new Dating();
            $dating->setId($row['id']);
            $dating->setUserId($row['userId']);
            $dating->setDesc($row['description']);
            $dating->setCost($row['cost']);
            $dating->setPhotoTime($row['photoTime']);
            $dating->setPostTime($row['postTime']);
            $dating->setPhotoAddress($row['photoAddress']);
            $dating->setPostAddress($row['postAddress']);
            $dating = $this->getDatingImagesAndTags($dating);
            array_push($datingArray, $dating);

        }

        return $datingArray;
    }



}