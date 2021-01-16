<?php
   include('session.php');
   
	if($user_check != "admin")   
    header("location:index.php");
	
	if($_GET['error'])
		$error = $_GET['error'];

  if($_SERVER["REQUEST_METHOD"] == "GET" &&  isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    if($userid == "1")
      $error = "Error cannot remove admin from the system!";
    else if(!remove_user($userid))
      $error = "Error : Unable to sync with database!";
    else
      header("location: admin.php");
  }
  
	if($_SERVER["REQUEST_METHOD"] == "GET" &&  isset($_GET['appid'])) {
		$appid = $_GET['appid'];
    if(!remove_app($appid))
      $error = "Error : Unable to sync with database!";
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
  <div class="row mt-3">
    <div class="col-sm-6 ">
      <div class="table-responsive">
      <h2>Admin Panel - Users</h2>
      <br/>
        <?php if ($error) { ?><div class="alert alert-danger">
                 <?php echo $error; ?>
              </div>
        <?php } ?>
        <table class="table">
        <thead>
         <tr><th>Username</th><th>Email Address</th><th>Actions</th></tr>
         </thead>
         <tbody>
            <?php foreach(get_users() as $userid => $userarr)
                  {
                    echo "<tr> <td> ".$userarr["username"]."</td><td>".$userarr["email"]."</td>";
//				          	echo "<td>".implode(",",$userapps)."</td>";
                    echo '<td><a href="edit_user.php?userid='.$userid.'" type="button" class="btn btn-info btn-sm">Edit</a>&nbsp;&nbsp;<a href="admin.php?delete&userid='.$userid.'" id="btnDelete" type="button" class="btn btn-danger btn-sm">Delete</a></td></tr>';
                  }
            ?>
         </tbody>
        </table>
        <br>
        <a href="add_user.php" type="button" class="btn btn-primary btn-sm">Add User</a>
       </div>
         <br><br>
  </div>
  <div class="col-sm-6 ">
      <div class="table-responsive">
      <h2>Applications</h2>
      <br/>
        <?php if ($error) { ?><div class="alert alert-danger">
                 <?php echo $error; ?>
              </div>
        <?php } ?>
        <table class="table">
        <thead>
         <tr><th>Application Name</th><th>Actions</th></tr>
         </thead>
         <tbody>
            <?php foreach(get_all_apps() as $appid => $apparr)
                  {
                    echo "<tr> <td> ".$apparr["appname"]."</td>";
                      //  echo "<td>".implode(",",$value)."</td>";	
                    echo '<td><a href="edit_app.php?appid='.$appid.'" type="button" class="btn btn-info btn-sm">Edit</a>&nbsp;&nbsp;<a href="admin.php?delete&appid='.$appid.'" id="btnDelete" type="button" class="btn btn-danger btn-sm">Delete</a></td></tr>';
                  }
            ?>
         </tbody>
        </table>
        <br>
        <a href="add_app.php" type="button" class="btn btn-primary btn-sm">Add App</a>
       </div>
         <br><br><div>
       </div>

  </div>
  </div>
   <br> <br>
</div>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
</html>