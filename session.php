<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   $userid = $_SESSION['userid'];
   $login_session = $user_check;
   
   if(!isset($_SESSION['login_user'])){
	   $redir =urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      header("location: login.php?pingback=$redir");
   }
?>