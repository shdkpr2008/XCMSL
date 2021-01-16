<?php
include('session.php');
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(ROOT_DIR))));
if($_GET['error'])
	$error = $_GET['error'];
if($_GET['success'])
	$success = $_GET['success'];


if($_GET['appid'])
{
	$appid = $_GET['appid'];
	$appname= get_app($appid)[$appid]["appname"];
	
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletecateg'])) {
		echo remove_app_progresscateg($appid, $_POST['deletecateg']);
		exit;
	}
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addcateg'])) {
		echo add_app_progresscateg($appid, $_POST['addcateg']);
		exit;
	}

	if(isset($_GET['categid']))
	{
		$categid = $_GET['categid'];
		if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteprogress'])) {
			echo remove_app_progress($_POST['deleteprogress']);
			exit;
		}
		if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addprogress'])) {
			echo add_app_progress($categid);
			exit;
		}

		$progress = get_app_progress($categid);
		$pgcp;
		foreach($progress as $progressid => $progressarr)
			$pgcp+=$progressarr["percent"];
		$pgcp = (count($progress) == 0 ? 0 : $pgcp/count($progress));
		
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$progressarr = array();
			foreach($_POST['team'] as $key => $value)
				$progressarr[$key] = array($_POST['team'][$key],$_POST['title'][$key],$_POST['percent'][$key],$_POST['notes'][$key]);

			if(update_app_progress($categid, $progressarr))
				header("location: index.php?appid=".$appid."&categid=".$categid."&success=Progress Updated Sucessfully!");
			else
				header("location: index.php?appid=".$appid."&categid=".$categid."&error=Error writing to database!");
		}
	}
	elseif (!array_key_exists($appid,get_apps($userid)) && $login_session != "admin")
	{
		echo "<script type='text/javascript'>window.location.href = 'index.php?error=Unauthorized Access to the app is not allowed!';</script>";	
		exit;
	}
	else
	{
		if($_SERVER["REQUEST_METHOD"] == "POST" && !$categid) {
			$app_info = $_POST;

			if(update_app_config($appid, $app_info))
				header("location: index.php?appid=".$appid);
			else
				header('location: index.php?error=Error in sync with database&appid='.$appid);
		}
	}
}


?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
      <li class="nav-item active">
		<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="upload_image.php">Image Upload</a>
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
    <?php if ($error) { ?><div class="alert alert-danger">
			 <?php echo $error; ?>
		  </div>
     <?php } if ($success) { ?><div class="alert alert-success">
			 <?php echo $success; ?>
		  </div>
	 <?php }

	 if($appid && $categid) { ?>
     
     <h2>App - <a href="index.php?appid=<?php echo $appid; ?>"><?php echo $appname; ?></a></h2>
     <h4> Progress Category : <?php echo get_app_progresscateg($appid)[$categid]; ?></h4>
     <?php if($pgcp) {?>
     <div class="progress" style="width:100%;display:inline-block;">
		<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $pgcp; ?>"
		aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $pgcp; ?>%">
		<?php echo $pgcp; ?>% Complete
		</div>
      </div>
      <?php } else {?>
		<p>0% Complete</p>
      <?php } ?>
      
   	<div class="col-md-12">
 
    <form action="" class="form-horizontal" method="post">
    <div id="form-fields">
     <div class="form-group row">
           <div class="col-sm-2">
            <label class="control-label col-sm-1" for="Team">Team</label>
            </div>
           <div class="col-sm-4">
            <label class="control-label col-sm-2" for="Title">Title</label>
            </div>
           <div class="col-sm-1">
            <label class="control-label col-sm-2" for="percentage">%</label>
            </div>
           <div class="col-sm-4">
            <label class="control-label col-sm-2" for="Notes">Notes</label>
            </div>
     </div>
     <?php 
	 	
		foreach($progress as $progressid => $progressarr)
		{ ?>
        <div class="form-group row">
            <div class="col-sm-2" style="width:10% !important;">
              <input type="text" class="form-control" name="team[<?php echo $progressid; ?>]" id="" placeholder="Team" value="<?php echo $progressarr["team"]; ?>">
            </div>
            <div class="col-sm-4"> 
             <textarea class="form-control" name="title[<?php echo $progressid; ?>]" id="" placeholder="Title" style="height:32px;max-width:100%;max-height:60px;overflow: hidden;" onkeyup="auto_grow(this)"><?php echo $progressarr["title"]; ?></textarea>
            </div>
            <div class="col-sm-1" style="padding-right:5px;padding-left:5px;">
            <input type="number" class="form-control" min="0" max="100" name="percent[<?php echo $progressid; ?>]" id="" placeholder="0" value="<?php echo $progressarr["percent"]; ?>">
            </div>
            <div class="col-sm-4">
              <textarea class="form-control" name="notes[<?php echo $progressid; ?>]" id="" placeholder="Note" style="height:32px;max-width:100%;max-height:60px;overflow: hidden;" onkeyup="auto_grow(this)"><?php echo $progressarr["notes"]; ?></textarea>
            </div>
            <button data-val="<?php echo $progressid; ?>" id="deletearow" type="button" class="btn btn-danger">Delete</button>
        </div>
		<?php }
	 ?>
     </div>
      <div class="form-group"> 
		<button id="addarow" type="button" class="float-right btn btn-success">Add a row</button>
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
      </form>
      </div>
     
	 
	 <?php } elseif($appid) { ?>
     
	<h2>App - <?php echo $appname; ?></h2>
	<div class ="row mt-5">
		<div class = "col-sm-6">
    <h4> Locations : </h4>
    <?php $app_dir = str_replace('./','/',$app_dir); ?>
    <p>URL : <span><a href="<?php echo "http://".$_SERVER[HTTP_HOST].ROOT_URL.$app_dir.$appname."/"; ?>"><?php echo "http://".$_SERVER[HTTP_HOST].ROOT_URL.$app_dir."/".$appname ?></a></span><br>
	Directory : <span><?php echo "".ROOT_DIR.$app_dir.$appname."/"; ?></span></p><br>
    
    
	<h4> Views : </h4>
    <p>WebView : <span><a href="<?php echo "http://".$_SERVER[HTTP_HOST].ROOT_URL.$webview_dir."?appid=".$appid ?>">
	<?php echo "http://".$_SERVER[HTTP_HOST].ROOT_URL.$webview_dir."?appid=".$appid ?></a></span><br>
	AppView : <span><a href="<?php echo "http://".$_SERVER[HTTP_HOST].ROOT_URL.$appview_dir."?appid=".$appid ?>">
	<?php echo "http://".$_SERVER[HTTP_HOST].ROOT_URL.$appview_dir."?appid=".$appid ?></a></span></p><br>
    
	<h4> Progress : </h4>
    <div id="form-fields">
   <?php $pgp; $i=0;
   foreach(get_app_progresscateg($appid) as $categid => $categname)
   {
	    $i++;
		$pgcp = 0;
		$progress = get_app_progress($categid);
		foreach($progress as $progressid => $progressarr)
			$pgcp+=$progressarr["percent"];
		$pgcp = (count($progress) == 0 ? 0 : $pgcp/count($progress));
		$pgp+=$pgcp;
   			echo 
			'<div class="row form-group">
            <label class="control-label col-sm-4" for="'.$categid.'"><a href="index.php?appid='.$appid.'&categid='.$categid.'" style="color:black;"><strong>'.$categname.'</strong></a></label>
            <div class="col-sm-'; if($i>11) echo "6"; else echo "8"; echo '">
				<div class="progress" style="width:'; if($i>11) echo "100"; else echo "100"; echo '%;display:inline-block;">';
				
				if($pgcp == 0)
					echo '0% Complete';
				else
					echo '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$pgcp.'"
				  aria-valuemin="0" aria-valuemax="100" style="width:'.$pgcp.'%">
					'.$pgcp.'% Complete
				  </div>';
				echo '</div>
            </div>';
				if($i>11)
				echo '<div><button id="deletecateg" onclick="deletecateg(this);" data-val="'.$categid.'" type="button" class="btn btn-danger">Delete</button></div>';
            echo '</div>';
   }
   $pgp = $pgp/count(get_app_progresscateg($appid));

    echo '</div>
	<div class="row form-group">
            <label class="control-label col-sm-4" for="addacateg"><strong>New Category</strong></label>
            <div class="col-sm-6">
				<input type="text" class="form-control" name="categ" id="categ" placeholder="Category goes here">
            </div>
				<div><button id="addcateg" type="button" class="btn btn-success">Add</button></div>
            </div>
	<div style="float:left;" > <strong>Overall Progress </strong>: &nbsp; &nbsp;</div><div class="progress" style="width:60%;display:inline-block;">';
	if($pgp == 0)
		echo '0% Complete';
	else
      echo '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$pgp.'"
      aria-valuemin="0" aria-valuemax="100" style="width:'.$pgp.'%">
        '.$pgp.'% Complete
      </div>';
    echo '</div>';  
    ?>
   </div>
    <div class="col-md-6 mb-5">
    <h4> Configurations : </h4>
     
        <form action="" class="form-horizontal" method="post">
        <?php
		foreach(get_app_config($appid) as $key => $value) { 
			if($key == "template") {  ?>
              <div class="row form-group">
                  <label class="control-label col-sm-4" for="<?php echo $key ?>"><?php echo $key ?> :</label>
                    <div class="col-sm-7">
                      <select type="text"  class="form-control" name="<?php echo $key ?>" id="<?php echo $key ?>" > 
	                      <option <?php if($value=="template1") echo "selected"; ?> value="template1">template1</option>
	                      <option <?php if($value=="template2") echo "selected"; ?> value="template2">template2</option>
	                      <option <?php if($value=="template3") echo "selected"; ?> value="template3">template3</option>
	                      <option <?php if($value=="template4") echo "selected"; ?> value="template4">template4</option>
	                      <option <?php if($value=="template5") echo "selected"; ?> value="template5">template5</option>
                      </select>
                    </div>
              </div>
			<?php } else { ?>
              <div class="row form-group">
                  <label class="control-label col-sm-4" for="<?php echo $key ?>"><?php echo $key ?> :</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $value ?>">
                    </div>
                    <?php list($txt, $ext) = explode(".", strtolower($value));
                    if($ext == "xml") {?>
                    <div class="col-sm-1">
                        <a href="live_editor.php?appid=<?php echo $appid; ?>&xmlfile=<?php echo $value; ?>" class="btn btn-info" role="button">Edit</a>
                    </div>
                    <?php } ?>
              </div>
          	<?php } ?>
          <?php } ?>
          <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Save</button>
            </div>
          </div>
        </form>
    
      <br> <br> <br>
      </div>
	  </div>
     <?php } else { ?>
  	<h2>Apps</h2>
    <p> Choose from the apps given below : </p>
    <div class="row">
	
	<?php
	   if($login_session == "admin"){
			/*foreach(get_users() as $userid => $userarr)
			{
				echo '<div class="col-md-4 col-top-offset-1"><h5> Username : <strong>'.$userarr["username"].'</strong></h5>';
				echo '<table style="width:80%;">';
				//echo '<a style="word-wrap:break-word;" href="live_editor.php?xmlfile='.$file.'">'.$file.'</a><br>';
				foreach(get_apps($userid) as $appid => $appdet)
				echo '<tr><td style="width:60%;"><a style="word-wrap:break-word;" href="index.php?appid='.$appid.'">'.$appdet["appname"].'</a></td>
				<!-- <td><button id="deleteapp" type="button" class="btn btn-xs btn-danger" style="">Del</button></td> -->
				</tr>';
				echo '<!-- <tr><td colspan="2">
				<div class="form-group">
					<div class="" style="display:inline;">
						<input type="text" name="appname" id="appname" style="width:50%" placeholder="AppName">
					</div>	
				<div style="margin-left: 20px;display:inline-block;"><button id="addapp" type="button" class="btn btn-xs btn-success">Add</button></div>
				</div></td></tr> -->
				</table>';
				?>
				<?php
				echo '</div>';
			}*/ ?>
			<div class="card-columns">
			<?php foreach(get_all_apps() as $appid => $apparr) {
					$users = get_app_users($appid); ?>
				<div class="card mb-4" style="width: 18rem;" onclick="window.location.href='index.php?appid=<?php echo $appid; ?>'">
					<div class="card-body">
					<h5 class="card-title"><a style="word-wrap:break-word;" href="index.php?appid=<?php echo $appid; ?>"><?php echo $apparr["appname"]; ?></a></h5>
					<p class="card-text">Users : <?php echo implode(", ", $users); ?> </p>
				</div>
			</div>
			<?php } ?>
			</div>
		<?php } else {?>
			<div class="card-columns">
			<?php foreach(get_all_apps() as $appid => $apparr) {
					$users = get_app_users($appid);
					if(in_array($userid, array_keys($users)))  { ?>
						<div class="card mb-4" style="width: 18rem;" onclick="window.location.href='index.php?appid=<?php echo $appid; ?>'">
							<div class="card-body">
							<h5 class="card-title"><a style="word-wrap:break-word;" href="index.php?appid=<?php echo $appid; ?>"><?php echo $apparr["appname"]; ?></a></h5>
							<p class="card-text">Users : <?php echo implode(", ", $users); ?> </p>
						</div>
			</div>
			<?php } } ?>
			</div>
		<?php } ?>
    </div>
    <?php } ?>
   </div>
  </div>
   <br> <br> <br>
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
<?php if($appid && $categid) { ?><script>
function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+"px";
}
$(document).ready(function(){

	var x = document.getElementsByName("title[]");
	var y = document.getElementsByName("notes[]");
	var i;
	for (i = 0; i < x.length; i++) {
		auto_grow(x[i]);
		auto_grow(y[i]);
	}

	$("#form-fields").on("click","button#deletearow", function(){
		$(this).parent('div').remove();
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'index.php?appid=<?php echo $appid; ?>&categid=<?php echo $categid; ?>');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send('deleteprogress=' + $(this).attr("data-val"));
		xhr.onload = function() {
			if(xhr.responseText == "1")
			{
				$(this).parent('div').remove();
			}
			else
				alert("Error deleting the progress");
		};
	});

	$("button#addarow").show().click(function(){
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'index.php?appid=<?php echo $appid; ?>&categid=<?php echo $categid; ?>');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send('addprogress');
		xhr.onload = function() {
			if(xhr.responseText == "")
				alert("Error adding the progress field");
			else
			{
				var div = document.createElement('div');
				var formfields = document.getElementById('form-fields');
				div.className = "row form-group";
				div.innerHTML = '<div class="col-sm-2" style="width:10% !important;">\
					<input type="text" class="form-control" name="team['+xhr.responseText+']" id="" placeholder="Team" value="">\
					</div>\
				<div class="col-sm-4">\
					<textarea class="form-control" name="title['+xhr.responseText+']" id="" placeholder="Title" style="height:32px;max-width:100%;max-height:60px;overflow: hidden;" onkeyup="auto_grow(this)"></textarea>\
					</div>\
				<div class="col-sm-1" style="padding-right:5px;padding-left:5px;">\
					<input type="number"  min="0" max="100" class="form-control" name="percent['+xhr.responseText+']" id=""  placeholder="0" value="">\
					</div>\
				<div class="col-sm-4">\
					<textarea class="form-control" name="notes['+xhr.responseText+']" id="" placeholder="Note" style="height:32px;max-width:100%;max-height:60px;overflow: hidden;" onkeyup="auto_grow(this)"></textarea>\
					</div>\
					<!--<div class="col-sm-2">--> \
						<button id="deletearow" type="button" class="btn btn-danger">Delete</button>\
					<!--</div>-->';
				formfields.appendChild(div);
			}
		};
	});
	
});

</script>
<?php } ?>
<?php if(($_GET['appid'])) { ?>
<script>

function deletecateg(el){
		var row = $(el);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'index.php?appid=<?php echo $appid; ?>');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send('deletecateg=' + $(el).attr("data-val"));
		xhr.onload = function() {
			if(xhr.responseText == "1")
				row.parent('div').parent('div').remove();
			else
				alert("Error deleting the category");
		};
	};

$(document).ready(function(){
	$(".form-group").on("click","button#addcateg", function(){
		var row = $(this).parent('div').parent('div').children(".col-sm-6").children("#categ");
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'index.php?appid=<?php echo $appid; ?>');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send('addcateg=' + row.val());
		xhr.onload = function() {
			if(xhr.responseText == "")
				alert("Error adding the category");
			else
			{
				var div = document.createElement('div');
				var formfields = document.getElementById('form-fields');
				div.className = "row form-group";
				div.innerHTML = '<label class="control-label col-sm-4" for="'+xhr.responseText+'"><a href="index.php?appid=<?php echo $appid; ?>&amp;categid='+xhr.responseText+'" style="color:black;"><strong>'+row.val()+'</strong></a></label><div class="col-sm-6"><div class="progress" style="width:100%;display:inline-block;">0% Complete</div></div><div><button id="deletecateg" onclick="deletecateg(this);" data-val="'+xhr.responseText+'" type="button" class="btn btn-danger">Delete</button></div>';
				formfields.appendChild(div);
				row.val("");
			}
		};	
	});
});
</script>
<?php } ?>
</html>