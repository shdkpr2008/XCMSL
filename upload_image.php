<?php
include('session.php');
error_reporting(0);
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(ROOT_DIR))));
if($_SERVER["REQUEST_METHOD"] == "POST") {
if($url = $_POST['url'])
{
	$name = basename($url);
	list($txt, $ext) = explode(".", strtolower($name));
	$name = uniqid().".".$ext;
		if(!($ext == "jpg" or $ext == "ai" or $ext == "jpeg" or $ext == "psd" or $ext == "png" or $ext == "svg" or $ext == "gif" or $ext == "doc" or $ext == "docx" or $ext == "pdf")){
		$invalid_file = true;
		$message = 'Oops!  Your file\'s type invalid, please upload images or docs only.';
	}
	if(!$invalid_file)
	{
		$target = getcwd().'/uploads/'.$name;
		$upload = file_put_contents($target,file_get_contents($url));
		if($upload)
			$message = "<strong>Success</strong><br>Image URL : <a href='uploads/".$name."' target='_blank'>http://".$_SERVER[HTTP_HOST].ROOT_URL."/uploads/".$name."</a>";
		else
			$message = "please check your folder permission";
		
	}
}
else
{
	//if no errors...
	if(!$_FILES['photo']['error'])
	{
		//now is the time to modify the future file name and validate the file
		if($_FILES['photo']['size'] > (25024000)) //can't be larger than 5 MB
		{
			$invalid_file = true;
			$message = 'Oops!  Your file\'s size is to large.';
		}
		
		list($txt, $ext) = explode(".", strtolower($_FILES["photo"]['name']));
		$name = uniqid().".".$ext;
		if(!($ext == "jpg" or $ext == "ai" or $ext == "jpeg" or $ext == "psd" or $ext == "png" or $ext == "svg" or $ext == "gif" or $ext == "doc" or $ext == "docx" or $ext == "pdf")){
			$invalid_file = true;
			$message = 'Oops!  Your file\'s type invalid, please upload images or docs only.';
		}

		//if the file has passed the test
		if(!$invalid_file)
		{
			//move it to where we want it to be
			$target = getcwd().'/uploads/'.$name;
			move_uploaded_file($_FILES['photo']['tmp_name'], $target);
			$message = "<strong>Success</strong><br>";
			$message.= "Image URL : <a href='uploads/".$name."' target='_blank'>http://".$_SERVER[HTTP_HOST].ROOT_URL."/uploads/".$name."</a>";
		}
	}
	//if there is an error...
	else
	{
		//set that to be the returned message
		$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
	}
}
}
?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
<meta charset="UTF-8">
<title>XCMSL Upload Image</title>
<link href="style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="container">
<nav class="navbar navbar-expand-lg">
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
        <a class="nav-link active" href="upload_image.php">Image Upload <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ticket.php">Ticket Panel</a>
      </li>
	<?php  if($login_session == "admin") { ?>
	  <li class="nav-item">
        <a class="nav-link" href="admin.php">Admin Panel</a>
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
  <div class="col-sm-11">
    <span><h2>Image Upload</h2></span>
  	<?php if($message) { ?>
    <div class="alert alert-warning">
  		<?php echo $message; ?>
	</div>
    <?php } ?>
<h3 class= "mb-3 mt-4">File Upload </h3>
<form action="#" method="post" enctype="multipart/form-data" style="display:flex;">
	Your Image : &nbsp;&nbsp;&nbsp;<input type="file" name="photo" size="25" />
   	<input type="submit" name="submit" value="Upload File" />
</form>
<h3 class= "mb-3 mt-4"> URL Upload </h3>
<form action="#" method="post">
	Your URL: <input type="text" name="url" />
       	<input type="submit" name="submit" value="Fetch URL" />
</form><br>
<br>
  	<div class="alert alert-info">
		<strong><a href="./uploads">View Already Uploaded Images!</a></strong>
	</div>

</div>
</div>
</div>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
</html>
