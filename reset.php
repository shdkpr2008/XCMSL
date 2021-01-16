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

  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password']) && isset($_POST['key']) && isset($_POST['reset'])) {
    if(verify_reset($_POST['key'],$_POST['reset']) == 1)
     {
      $password = $_POST['password'];
      $hash = ;
      if(password_reset($hash, $_POST['key'],$_POST['reset']) == 1)
        header("location: login.php?success=Password successfully updated!");
      else
        $error = "Error in sync with database";
     }
     else
        $error = "Invalid keys, please try again!";
  }
       
  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
      // username and password sent from form 
      $email = $_POST['email'];
      $uid = get_useridfe($email);

      if($uid > 0)
      {
        $username = get_username($uid);
        $passhash = get_passhash($username);
        $key=md5($email);
        $reset=md5($passhash);
        $link = "http://".$_SERVER[HTTP_HOST].ROOT_URL."/reset.php?key=".$key."&reset=".$reset;
        $subject = 'Password reset request';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
              'Reply-To: '.$from."\r\n" .
              'X-Mailer: PHP/' . phpversion();
        $message = '<html><body>';
        $message .= 'Dear user, <br><br>';
        $message .= 'Kindly follow the url below to reset your password.<br>';
        $message .= '<a href="'.$link.'">'.$link.'</a>';
        $message .= '<br><br>';
        $message .= 'Regards';
        $message .= '</body></html>';
        $result = mail($email, $subject, $message, $headers);
        if($result)
          $success = "Kindly check your inbox!";
        else
          $error = "We are unable to mail you!";
      }
      else
      {
        $error = "No such record exists!";
      }
   }
?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
	<meta charset="UTF-8">
	<title>XCMSL Password Reset</title>
	<link href="style.css" media="all" rel="stylesheet" >
</head>
<body>
<div class="container">
  <div class="row">
    <div class="login-form is-Responsive">
      <div id="logo-container"></div>
      <!--<p align="center">XCSML Reset</p>-->
      <div class="col-sm-12 ">
        <form action="" id="resetForm" method="post">
        <?php if($_GET['key'] && $_GET['reset']) { 
            if(verify_reset($_GET['key'],$_GET['reset']) == 1)
            {
              ?>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input class="form-control" type="text" name='password' placeholder="password"/>
                <input class="form-control" type="hidden" name='key' value="<?php echo $_GET['key']; ?>" />
                <input class="form-control" type="hidden" name='reset' value="<?php echo $_GET['reset']; ?>" />
              </div>
              <div class="form-group">
                <button type="submit"  class="btn btn-primary btn-block">Update Password</button>
              </div>
        <?php
            }
            else
              $error = "Invalid keys, please try again!";
        } else { ?> 
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control" type="text" name='email' placeholder="email"/>          
          </div>
          <div class="form-group">
            <button type="submit"  class="btn btn-primary btn-block">Send Reset Link</button>
          </div>
        <?php } ?>
          <div class="alert alert-danger"  <?php if(!$error) echo 'style="display:none;"'; ?>>
			      <?php if($error) echo $error;?>
          </div>
          <div class="alert alert-success"  <?php if(!$success) echo 'style="display:none;"'; ?>>
			      <?php if($success) echo $success;?>
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
</html>