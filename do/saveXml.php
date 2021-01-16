<?php
error_reporting(0);
require_once('../config.php');
$user_file = "../".$user_file;
require_once('../session.php');
$user_file = "../".$user_file;
require_once('../users.php');
$login_session = $_SESSION['login_user'];
/**
 * Saves POST input as an XML file and returns a JSON response
 */
$xmlString;
if (isset($_POST['xmlString'])){
	//$filename  = $_POST['xmlFilename'];
	$appid = $_POST['appid'];
	$appname = get_app($appid)[$appid]["appname"];
	$xmlFilename = $_POST['xmlFilename'];
	$xmlString = stripslashes($_POST['xmlString']);
	$xmlString  = str_replace(' xml:space=&apos;preserve&apos;', '', $xmlString);
	$xmlString = htmlspecialchars_decode($xmlString);
	$filename  = str_replace('../', '', $_POST['xmlFilename']);
	$newFile = "../".$app_dir.$appname."/".$xmlFilename;
	
	if(!array_key_exists($appid,get_apps($userid)) && $login_session != "admin")
		$json = array("success" => "false");
	else
	{
		//write new data to the file, along with the old data 
		$handle = fopen($newFile, "w"); 
		if (fwrite($handle, $xmlString) === false) { 
			$json = array("success" => "false");
		} 
		else {
			$json = array("success" => "true");
		}
		fclose($handle); 	
	}
	
	 header("Content-Type: application/json", true);
     echo json_encode($json);
     exit;
	
}
?>