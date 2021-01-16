<?php

	//Filename : config.php
	//Description : Configurations

    define('ROOT_DIR', dirname(__FILE__));
    define('ROOT_URL', substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(ROOT_DIR))));
        
    //Error Reporting
    error_reporting(0);
    
    //MySQLi Config
    $servername = "localhost";
    $dbuser = "xcmsl";
    $dbpass = "xcmsl";
    $dbname = "xcmsl";
    
    //MySQLi Connection
    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    //Functions
    include('functions.php');

    //Headers    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    
    }


    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    header('Access-Control-Allow-Origin: *');

    //Configuration File
    $user_file = 'users.data';
    $apps_file = 'apps.data';

    // Working Directories
    $xml_dir = "./";
    $app_dir = "./app/";
    $webview_dir = "/webview/";
    $appview_dir = "/appview/";

    //Google Social-ID
    $gscid = "";

    //From Email
    $from = '';

    include('users.php'); 
?>
