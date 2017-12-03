<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Dating: 2017/11/1
 * Time: 20:42
 */
require_once(dirname(__FILE__) . '/../handler/AlbumHandler.php');
$option = "";
if (isset($_GET["option"]))
    $option = $_GET["option"];
if (isset($_POST["option"]))
    $option = $_POST["option"];
$albumHandler = new AlbumHandler();


switch ($option) {
    case "upload":
        $albumHandler->addAlbum();
        break;

    case "update":
        $albumHandler->updateAlbum();
        break;

    case "delete":
        $albumHandler->deleteAlbum();
        break;

    case "getUserAlbum":
        $albumHandler->getUserAlbums();
        break;

    case "getAlbumByAlbumId":
        $albumHandler->getAlbumByAlbumId();
        break;


}