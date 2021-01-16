<?php
  require_once "config.php" ;
     session_start();

  if(isset($_SESSION['login_user'])){
     header("location:index.php");
  }

  if($_GET['error'])
     $error = $_GET['error'];

  if($_GET['success'])
    $success = $_GET['success'];

  if($_GET['pingback'])
     $pingback = $_GET['pingback'];

  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
      // username and password sent from form 
      $username = $_POST['username'];
      $password = $_POST['password']; 

      if(password_verify($password, get_passhash($username))) {
         $_SESSION['login_user'] = $username;
         $_SESSION['userid'] = get_userid($username);
          if($pingback)
            header("location: $pingback");
          else
            header("location: index.php");
      }else {
         $error = "Invalid Login Name or Password!";
      }
   }
   if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_token'])) {
      //We are getting respnse from google api   
      $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='.$_POST['id_token'];
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      $json = json_decode($response, true);
      curl_close($ch);

      $userid = get_useridfe($json["email"]);
      if(isset($userid) === true && $userid === '')
        echo false;
      else 
      {
        $_SESSION['login_user'] = get_username($userid);
        $_SESSION['userid'] = $userid;
        echo true;
      }
      exit;
   }
?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
	<meta charset="UTF-8">
	<title>XCMSL Login</title>
	<link href="style.css" media="all" rel="stylesheet" >
	<meta name="google-signin-client_id" content="<?php echo $gscid; ?>">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="login-form is-Responsive">
      <div id="logo-container"></div>
      <!--<p align="center">XCSML Login</p>-->
      <div class="col-sm-12 ">
        <form action="" id="loginForm" method="post">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control" type="text" name='username' placeholder="username"/>          
          </div>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input class="form-control" type="password" name='password' placeholder="password"/>     
          </div>
          <div class="form-group">
            <button type="submit"  class="btn btn-primary btn-block">Login</button>
            <a href="reset.php" style="margin: 5px auto;display:table;">Reset password</a>
          </div>
          <div class="form-group" align="center">
                    <p>Or log-in using your google account :</p>
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
          </div>
          <div class="alert alert-danger"  <?php if(!$error) echo 'style="display:none;"'; ?>>
			 <?php if($error) echo $error; else echo 'You are not in the users list, kindly contact the administrator! <a onClick="signOut();" href="#">Logout</a>'; ?>
		  </div>
           <div class="alert alert-success" <?php if(!$success) echo 'style="display:none;"'; ?> >
                  <?php if($success) echo $success; ?>
            </div>
           <div id="loginsuccess" class="alert alert-success" style="display:none;">
                Please wait while we redirect you.
           </div>
        </form>        
      </div>  
    </div>    
  </div>
</div>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
	$("#loginsuccess").hide();
});
 function signOut() {
      var auth2 = gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        window.location.href = 'login.php';
      });
    }
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  var id_token = googleUser.getAuthResponse().id_token;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'login.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('id_token=' + id_token);
  xhr.onload = function() {
	if(xhr.responseText =="1")
	{
		$(".alert-danger").hide();
		$("#loginsuccess").show();
    <?php if($pingback) 
       echo "window.location.href = '".$pingback."';";
       else 
       echo "window.location.href = 'index.php';";
    ?>
    
	}
	else if(xhr.responseText =="")
	{
		$(".alert-danger").show();
		$("#loginsuccess").hide();
	}
  };
}
</script>
</html>