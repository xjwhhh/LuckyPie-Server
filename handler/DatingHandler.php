<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:41
 */

require_once ("SimpleHandler.php");
require_once(dirname(__FILE__) . '/../data/DatingData.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class datingHandler extends  SimpleHandler{

    private $datingData;

    function __construct()
    {
        $this->datingData = new DatingData();
    }

    public function getHotDating(){

    }

    public function getFollowingDating(){

    }

    public function getExploreDating(){

    }

    public function getUserDating(){

    }

    public function addDating(){
        if(isset($_POST['datingInfo'])){
            $datingInfo=$_POST['datingInfo'];
        }
        $dating=json_decode($datingInfo);
        $result=$this->datingData->insertDating($dating);

//        echo $datingInfo;
//        print_r($dating);
        echo  $result;
    }

    public function updateDating(){

    }

    public function deleteDating(){

    }

}