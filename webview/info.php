<?php 
error_reporting(0);
$appid = $_GET["appid"];
include('../config.php'); 
$appname= get_app($appid)[$appid]["appname"];
$app_dir = "../".$app_dir;
$app_info = get_app_config($appid);
if($app_info["template"] == "")
  $template = "template1".".php";
else
  $template = $app_info["template"].".php";
?>