<?php
include('session.php');

if($user_check != "admin")   
header("location:index.php");

if($_GET['error'])
$error = $_GET['error'];

if($_GET['userid'] || $_SERVER["REQUEST_METHOD"] == "POST")
{
  $user = get_users()[$_GET['userid']];
  $users = get_users();
  unset($users[$_GET['userid']]);
}  
else
  header("location: admin.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST['username'];
	$password = $_POST['password']; 
  $email = $_POST['email']; 
  
	if($password == "")
		$hash =  get_passhash($username);
	else
		$hash = password_hash($password, PASSWORD_DEFAULT);

  if($email == "")
		header('location: edit_user.php?error=Invalid email address, email address cannot be empty!&userid='.$_GET['userid']);
  else if(in_array_r($email, $users))
    header('location: edit_user.php?error=Email address already in use!&userid='.$_GET['userid']);	
  else if(!update_user($username, $hash, $email, $_GET['userid']))
    header('location: edit_user.php?error=Error in sync with database&userid='.$_GET['userid']);
  else
    header("location: admin.php");
}


?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
<meta charset="UTF-8">
<title>XCMSL Editor - Welcome <?php echo $login_session; ?></title>
<link href="style.css" media="all" rel="stylesheet" >
</head>
<body>
<div class="container">
<nav class="navbar navbar-expand-lg ">
  <div id="nav-logo-container"></div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
		<a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="upload_image.php">Image Upload</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ticket.php">Ticket Panel</a>
      </li>
	<?php  if($login_session == "admin") { ?>
	  <li class="nav-item active">
        <a class="nav-link" href="admin.php">Admin Panel <span class="sr-only">(current)</span></a>
      </li>
    <?php } ?>
    </ul>
    <form class="form-inline my-2 my-lg-0">
	  <a class="navbar-brand" href="#">Welcome <?php echo $login_session; ?></a>
      <a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
    </form>
  </div>
</nav>
  <div class="row mt-3 offset-sm-1">
  <div class="col-sm-11 mb-5">

  <h2>Users Management</h2>
  <br/>
    <h4>Edit user</h4>
        <form action="" id="loginForm" method="post">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control" type="text" name='username' value="<?php echo $user["username"]; ?>" readonly/>          
          </div>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input class="form-control" type="password" name='password' placeholder="password"/>     
          </div>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input class="form-control" type="email" name='email' value="<?php echo $user["email"]; ?>"/>     
          </div>
          <div class="form-group">
            <button type="submit"  class="btn btn-primary float-right ">Update User</button>
          </div>
          <?php if ($error) { ?><div class="alert alert-danger">
			 <?php echo $error; ?>
		  </div>
          <?php } ?>
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
<script src="http://bootboxjs.com/bootbox.js"></script>
</html>