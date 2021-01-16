<?php 
error_reporting(0);
$appid = $_GET["appid"];
include('../config.php'); 
$appname= get_app($appid)[$appid]["appname"];
$app_dir = "../".$app_dir;
$app_info = get_app_config($appid);
?>