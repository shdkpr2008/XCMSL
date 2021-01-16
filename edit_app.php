<?php
include('session.php');

if($user_check != "admin")   
  header("location:index.php");
  
if($_GET['error'])
	$error = $_GET['error'];

if($_GET['appid']){
  $appid = $_GET['appid'];
  $app = get_app($appid)[$appid];
}
else
  header("location: admin.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$appusers = $_POST['appusers']; 
	
	if($app["appname"] == "")
		$error = "No appname is recieved!";
  else if(update_app($appid, $appusers))
    header("location: admin.php");
  else
    header('location: edit_app.php?&appid='.$appid.'&error=Error in sync with database!');
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
  <h2>Application Management</h2>
  <br/>
    <h4>Edit an application</h4>
       <form action="edit_app.php?appid=<?php echo $appid; ?>" id="appEditForm" method="post">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
            <input class="form-control" type="text" name='appname' value="<?php echo $app["appname"]; ?>" readonly/>     
          </div>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<label style="padding:6px 12px;background-color:#eee;border:1px solid #ccc;margin-bottom:0px !important;">Select from the users below to be assigned to the app : </label>
          </div>
			<?php
        $assigned_users = array_keys(get_app_users($appid));    
        foreach(get_users() as $userid => $userarr) { ?>
              <div class="checkbox">
              <label class="checkbox"><input type="checkbox" name="appusers[]" value="<?php echo $userid; ?>" <?php if(in_array($userid, $assigned_users)) echo 'checked'; ?>><?php echo $userarr["username"]; ?></label>
              </div>
			<?php } ?>
          <div class="form-group">
            <button type="submit"  class="btn btn-primary float-right ">Edit App</button>
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