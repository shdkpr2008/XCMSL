<?php
error_reporting(0);
require_once('../config.php');
$user_file = "../".$user_file;
require_once('../session.php');
$user_file = "../".$user_file;
require_once('../users.php');
$login_session = $_SESSION['login_user'];
$xmlFilename;
if (isset($_POST['xmlFilename'])){
	$appid = $_POST['appid'];
	$appname = get_app($appid)[$appid]["appname"];
	$xmlFilename = $_POST['xmlFilename'];
	if(!array_key_exists($appid,get_apps($userid)) && $login_session != "admin")
		$json = array("success" => "false");
	else{
		$filename  = str_replace('../', '', $_POST['xmlFilename']);
		$newFile = "../".$app_dir.$appname."/".$xmlFilename;
		if (unlink($newFile)) {
			$json = array("success" => "true");
		} else {
			$json = array("success" => "false");
		}
		if (count(glob(dirname($newFile)."/*")) === 0 )
			rmdir(dirname($newFile));	
	}
	 header("Content-Type: application/json", true);
	 echo json_encode($json);
	 exit;
}
?>

