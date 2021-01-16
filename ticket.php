<?php
include('session.php');
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(ROOT_DIR))));
if($_GET['error'])
	$error = $_GET['error'];

if($_GET['success'])
	$success = $_GET['success'];
	
if($appid = $_GET['appid'])
{
	$appname = get_app($appid)[$appid]["appname"];
	$ticketid = $_GET["show_ticket"] | $_GET["hold_ticket"] | $_GET["close_ticket"];
	if(!array_key_exists($appid,get_apps($userid)) && $login_session != "admin" && !in_array($userid,array_keys(get_app_ticket_staff($ticketid))))
	{
		echo "<script type='text/javascript'>window.location.href = 'index.php?error=Unauthorized Access to the app is not allowed!';</script>";	
		exit;
	}		
	else
	{
		if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["assign"] && $ticketid = $_GET["show_ticket"]) {
			$ticketstaff = $_POST["ticketstaff"];
			if(update_app_ticket_staff($ticketid, $ticketstaff)) {
				$ticket = get_app_ticket($ticketid);
				$assigned_staff = array_keys(get_app_ticket_staff($ticketid));	
				$assigned_users = array_keys(get_app_users($appid));
				$all_users = get_users();
				//$mailto = array_unique(array_merge($assigned_staff, $assigned_users));

			     $subject = 'Ticket '.$ticket["title"].' has been assigned to you! - '.$appname;
				 $headers  = 'MIME-Version: 1.0' . "\r\n";
				 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				 $headers .= 'From: '.$from."\r\n".
							 'Reply-To: '.$from."\r\n" .
							 'X-Mailer: PHP/' . phpversion();
				 $message = '<html><body>';
				 $mfile = file("./email/assign.txt");
				 foreach($mfile as $val)
				 	$message = $message.$val.'<br>';
				 $message .= '</body></html>';
				 $message = str_replace('_ID_',$ticketid,$message);
				 $message = str_replace('_TITLE_',$ticket["title"],$message);
				 $url  = "http://".$_SERVER[HTTP_HOST].ROOT_URL."/ticket.php?show_ticket=".$ticketid."&appid=".$appid;
				 $message = str_replace('_URL_',$url,$message);
				 
				 foreach($assigned_staff as $userid)
				 {
					 	$to = $all_users[$userid]["email"];
					 	$nmessage = str_replace('_RUSER_',$all_users[$userid]["username"],$message);
						 mail($to, $subject, $nmessage, $headers);
				 }
				header("location: ticket.php?success=Users to ticket %23".$ticketid." has been assigned sucessfully.&show_ticket=".$ticketid."&appid=".$appid);
			}else
				 header('location: ticket.php?error=Error in sync with database');
		}
		else if($_SERVER["REQUEST_METHOD"] == "POST" && $message = $_POST["reply"] && $ticketid = $_GET["show_ticket"]) {
			$status = "Replied";
			$message = $_POST["reply"];

			if(add_app_ticket_message($ticketid, $userid, $message) && update_app_ticket_status($ticketid, $status)) {
				$ticket = get_app_ticket($ticketid);
				$assigned_staff = array_keys(get_app_ticket_staff($ticketid));	
				$assigned_users = array_keys(get_app_users($appid));
				$all_users = get_users();
				$mailto = array_unique(array_merge($assigned_staff, $assigned_users));
				
				$subject = 'Ticket '.$ticket["title"].' has got a new reply! - '.$appname;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.$from."\r\n".
							'Reply-To: '.$from."\r\n" .
							'X-Mailer: PHP/' . phpversion();
				$message = '<html><body>';
				$mfile = file("./email/reply.txt");
				foreach($mfile as $val)
				$message = $message.$val.'<br>';
				$message .= '</body></html>';
				$message = str_replace('_ID_',$ticketid,$message);
				$message = str_replace('_TITLE_',$ticket["title"],$message);
				$url  = "http://".$_SERVER[HTTP_HOST].ROOT_URL."/ticket.php?show_ticket=".$ticketid."&appid=".$appid;
				$message = str_replace('_URL_',$url,$message);
				foreach($mailto as $userid)
				{
					$to = $all_users[$userid]["email"];
					$nmessage = str_replace('_RUSER_',$all_users[$userid]["username"],$message);
					mail($to, $subject, $nmessage, $headers);
				}
			 	header("location: ticket.php?success=A reply to ticket %23".$ticketid." has been added sucessfully.&show_ticket=".$ticketid."&appid=".$appid);
			}else
				 header('location: ticket.php?error=Error in sync with database');
			
		}
		else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["add_ticket"])) {

			$ticket = array("title" => $_POST["title"],
							"status" => "Open",
							"priority" => $_POST["priority"],
							"category" => $_POST["category"],
							"message" => $_POST["message"]
							);

			  if($ticketid = add_app_ticket($appid, $ticket)) {
					$ticket = get_app_ticket($ticketid);
					$assigned_staff = array_keys(get_app_ticket_staff($ticketid));	
					$assigned_users = array_keys(get_app_users($appid));
					$all_users = get_users();
					$mailto = array_unique(array_merge($assigned_staff, $assigned_users));

					$subject = 'A new ticket '.$ticket["title"].' has been created - '.$appname;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.$from."\r\n".
								'Reply-To: '.$from."\r\n" .
								'X-Mailer: PHP/' . phpversion();
					$message = '<html><body>';
					$mfile = file("./email/open.txt");
					foreach($mfile as $val)
						$message = $message.$val.'<br>';
					$message .= '</body></html>';
					$message = str_replace('_ID_',$ticketid,$message);
					$message = str_replace('_TITLE_',$ticket["title"],$message);
					$url  = "http://".$_SERVER[HTTP_HOST].ROOT_URL."/ticket.php?show_ticket=".$ticketid."&appid=".$appid;
					$message = str_replace('_URL_',$url,$message);
					foreach($mailto as $userid)
					{
						$to = $all_users[$userid]["email"];
						$nmessage = str_replace('_RUSER_',$all_users[$userid]["username"],$message);
						mail($to, $subject, $nmessage, $headers);
					}
					header("location: ticket.php?success=New Ticket %23".$ticketid." added sucessfully.&show_ticket=".$ticketid."&appid=".$appid);
				}else
				 	header('location: ticket.php?error=Error in sync with database');
		}
		else if($ticketid = $_GET["delete_ticket"]) {
			if(remove_app_ticket($ticketid))
				header("location: ticket.php?success=Ticket %23".$ticketid." has been deleted!");
			else
				header('location: ticket.php?error=Error in sync with database');
		}
		else if($ticketid = $_GET["hold_ticket"]) {
			  $status = "On Hold";
			  
			  if(update_app_ticket_status($ticketid, $status)) {
					$ticket = get_app_ticket($ticketid);
					$assigned_staff = array_keys(get_app_ticket_staff($ticketid));	
					$assigned_users = array_keys(get_app_users($appid));
					$all_users = get_users();
					$mailto = array_unique(array_merge($assigned_staff, $assigned_users));
					
					$subject = 'Ticket '.$ticket["title"].' has put on hold! - '.$app;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.$from."\r\n".
								'Reply-To: '.$from."\r\n" .
								'X-Mailer: PHP/' . phpversion();
					$message = '<html><body>';
					$mfile = file("./email/hold.txt");
					foreach($mfile as $val)
						$message = $message.$val.'<br>';
					$message .= '</body></html>';
					$message = str_replace('_ID_',$ticketid,$message);
					$message = str_replace('_TITLE_',$ticket["title"],$message);
					$url  = "http://".$_SERVER[HTTP_HOST].ROOT_URL."/ticket.php?show_ticket=".$ticketid."&appid=".$appid;
					$message = str_replace('_URL_',$url,$message);
					foreach($mailto as $userid)
					{
						$to = $all_users[$userid]["email"];
						$nmessage = str_replace('_RUSER_',$all_users[$userid]["username"],$message);
						mail($to, $subject, $nmessage, $headers);
					}
				 	header("location: ticket.php?success=Ticket %23".$ticketid." Status Changed To '".$status."'!");
			  	}else
					 header('location: ticket.php?error=Error in sync with database');
		}
		else if($ticketid = $_GET["close_ticket"]) {
				$status = "Closed";

				if(update_app_ticket_status($ticketid, $status)){
					$ticket = get_app_ticket($ticketid);
					$assigned_staff = array_keys(get_app_ticket_staff($ticketid));	
					$assigned_users = array_keys(get_app_users($appid));
					$all_users = get_users();
					$mailto = array_unique(array_merge($assigned_staff, $assigned_users));
	
					$subject = 'Ticket '.$ticket["title"].' has been closed! - '.$appname;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.$from."\r\n".
								'Reply-To: '.$from."\r\n" .
								'X-Mailer: PHP/' . phpversion();
					$message = '<html><body>';
					$mfile = file("./email/closed.txt");
					foreach($mfile as $val)
					$message = $message.$val.'<br>';
					$message .= '</body></html>';
					$message = str_replace('_ID_',$ticketid,$message);
					$message = str_replace('_TITLE_',$ticket["title"],$message);
					$url  = "http://".$_SERVER[HTTP_HOST].ROOT_URL."/ticket.php?show_ticket=".$ticketid."&appid=".$appid;
					$message = str_replace('_URL_',$url,$message);
					foreach($mailto as $userid)
					{
						$to = $all_users[$userid]["email"];
						$nmessage = str_replace('_RUSER_',$all_users[$userid]["username"],$message);
						mail($to, $subject, $nmessage, $headers);
					}
					header("location: ticket.php?success=Ticket %23".$ticketid." has been closed!");
				}else
				 	header('location: ticket.php?error=Error in sync with database');
		}
	}
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
      <li class="nav-item active">
        <a class="nav-link" href="ticket.php">Ticket Panel <span class="sr-only">(current)</span></a>
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
     <?php }
	if ($success) { ?><div class="alert alert-success">
			 <?php echo $success; ?>
		  </div>
     <?php } if(isset($_GET["add_ticket"])) { ?>
     
        <h2>Add a Ticket - <?php echo $appname; ?></h2><br>
        <form action="" class="form-horizontal" method="post">
        
        <div class="form-group">
        <label class="control-label col-sm-2" for="title">Title :</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" name="title" id="title" placeholder="Title">
        </div>
          </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="priority">Priority :</label>
        <div class="col-sm-5">
          <select name="priority">
          <option value="Low">Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
          </select>
        </div>
         </div>
         
		<div class="form-group">
        <label class="control-label col-sm-2" for="category">Category :</label>
        <div class="col-sm-5">
          <select name="category">
          <option value="Design">Design</option>
          <option value="Programming">Programming</option>
          <option value="Content Management">Content Management</option>
          </select>
        </div>
         </div>
                  
        <div class="form-group">
        <label class="control-label col-sm-2" for="message">Message :</label>
        <div class="col-sm-5">
         <textarea rows="10" cols="70" name="message"></textarea>
        </div>
                  </div>
        <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
        </div>
        </form> 

	 	
	 <?php } else if($ticketid =  $_GET["show_ticket"]) { 
	 $ticket = get_app_ticket($ticketid);
	 $assigned_staff = get_app_ticket_staff($ticketid);	
	 $assigned_users = array_keys(get_app_users($appid));

	 echo '<h2>Application Ticket Panel</h2>
	 <h6>App Name : '.$appname.'</h6>
	 <h6>Ticket ID : '.$ticketid.'</h6><br>
	 <h5>Title : <strong>'.$ticket["title"] .'</strong></h5>
	 <h5>Status : <strong>'.$ticket["status"] .'</strong></h5>
	 <h5>Category : <strong>'.$ticket["category"] .'</strong></h5>
	 <h5>Priority : <strong>'.$ticket["priority"] .'</strong></h5>
	 <h5>Staff Assigned : <strong>'.implode(", ", $assigned_staff).'</strong></h5><br>';
	 
	 if($login_session == "admin") { ?>
        <form action="<?php echo "ticket.php?assign=1&show_ticket=".$ticketid."&appid=".$appid  ?>" id="appAddForm" method="post">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<label style="padding:6px 12px;background-color:#eee;border:1px solid #ccc;margin-bottom:0px !important;">Select users to be assigned to this ticket : </label>
          </div>
			<?php
			 foreach(get_users() as $userid => $userarr) { ?>
				<div class="checkbox">
					<label class="checkbox"><input type="checkbox" name="ticketstaff[]" value="<?php echo $userid; ?>" <?php if(in_array($userid, $assigned_users)) echo 'checked disabled'; else if(in_array($userid, array_keys($assigned_staff))) echo 'checked'; ?>><?php echo $userarr["username"]; ?></label>
					<input type="hidden" name="assign" value="1" />
				</div>
			<?php } ?>
          <div class="form-group">
            <button type="submit"  class="btn btn-primary ">Assign users to this ticket</button>
          </div>
          <?php if ($error) { ?><div class="alert alert-danger">
			 <?php echo $error; ?>
		  </div>
          <?php } ?>
        </form>   
		<br>
	 <?php
	 }
	 foreach(get_app_ticket_messages($ticketid) as $messageid => $messagearr)
	 {
		 ?>
		 <div class="card mt-2 mb-2">
			<h6 class="card-header"><?php echo  $messagearr["username"]; ?> <time class="entry-date float-right" datetime="<?php echo  $messagearr["datetime"]; ?>" pubdate=""><?php echo  $messagearr["datetime"]; ?></time></h6>
				
			<div class="card-body">
				<p class="card-text"><?php echo preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]/i', '<a target="_blank" href="\0">\0</a>', $messagearr["message"]); ?></p>
			</div>
		</div>
         <?php 
	 }
	 ?>
	 
	    <div class="col-sm-12 " style="" ><br><br><h4>Add a Reply</h4>
        <form action="" class="form-horizontal" method="post">
		<div class="form-group">
			<label for="exampleFormControlTextarea1">Message : </label>
			<textarea class="form-control" name="reply" id="exampleFormControlTextarea1" rows="3"></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>

        </form> 
        </div>

	 
     
	
    <?php } else { ?>
  	<h2>Apps Ticket Panel</h2>
    <div class="col col-md-12">
	<?php

	   if($login_session == "admin")
	   {
			echo '<div class="col-xs-12 col-top-offset-1">';
			foreach(get_all_apps() as $appid => $apparr)
			{
				echo 'App Name : <strong>'.$apparr["appname"].'</strong>';
				echo '<p><table id="'.$appid.'" class="display" cellspacing="0" width="100%"><thead><tr><th>Ticket ID</th><th>Title</th><th>Status</th><th>Priority</th><th>Actions</th></tr></thead><tbody>';
				foreach(get_app_tickets($appid) as $ticketid => $ticket)
					echo '<tr><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticketid.'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.substr($ticket["title"], 0, 30).'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticket["status"].'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticket["priority"].'</td><td><a href="?show_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-primary" role="button">Show</a>&nbsp;&nbsp;&nbsp;<a href="?hold_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-warning" role="button">Hold</a>&nbsp;&nbsp;&nbsp;<a href="?close_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-info" role="button">Close</a>&nbsp;&nbsp;&nbsp;<a href="?delete_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-danger" role="button">Delete</a></td></tr>';
				echo '</tbody></table><a href="?add_ticket&appid='.$appid.'" class="btn btn-sm btn-info" role="button">Add a Ticket</a></p><br><br>';
			}
			echo '</div>';
		}
		else
		{
			echo '<div class="col-xs-12 col-top-offset-1"><h5> Username : <strong>'.$login_session.'</strong></h5><br>';
			foreach(get_apps($userid) as $appid => $appdet)
			{
				echo 'App Name : <strong>'.$apparr["appname"].'</strong>';
				echo '<p><table id="'.$appid.'" class="display" cellspacing="0" width="100%"><thead><tr><th>Ticket ID</th><th>Title</th><th>Status</th><th>Priority</th><th>Actions</th></tr></thead><tbody>';
				foreach(get_app_tickets($appid) as $ticketid => $ticket)
					echo '<tr><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticketid.'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.substr($ticket["title"], 0, 30).'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticket["status"].'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticket["priority"].'</td><td><a href="?show_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-primary" role="button">Show</a>&nbsp;&nbsp;&nbsp;<a href="?hold_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-warning" role="button">Hold</a>&nbsp;&nbsp;&nbsp;<a href="?close_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-info" role="button">Close</a>&nbsp;&nbsp;&nbsp;<a href="?delete_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-danger" role="button">Delete</a></td></tr>';
				echo '</tbody></table><a href="?add_ticket&appid='.$appid.'" class="btn btn-sm btn-info" role="button">Add a Ticket</a></p><br><br>';
			}
			echo '</div>';
			
			echo '<div class="col-xs-12 col-top-offset-1">';
				echo 'Staff Assginments : <strong>Tickets assigned to you</strong>';
				echo '<p><table id="assigned" class="display" cellspacing="0" width="100%"><thead><tr><th>Ticket ID</th><th>Title</th><th>Status</th><th>Priority</th><th>Actions</th></tr></thead><tbody>';
			foreach(get_app_staff_tickets($userid) as $ticketid)
			{
				$ticket = get_app_ticket($ticketid);
				echo '<tr><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticketid.'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.substr($ticket["title"], 0, 30).'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticket["status"].'</td><td onclick="window.location.href=\'?show_ticket='.$ticketid.'&appid='.$appid.'\'" >'.$ticket["priority"].'</td><td><a href="?show_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-primary" role="button">Show</a>&nbsp;&nbsp;&nbsp;<a href="?hold_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-warning" role="button">Hold</a>&nbsp;&nbsp;&nbsp;<a href="?close_ticket='.$ticketid.'&appid='.$appid.'" class="btn btn-xs btn-info" role="button">Close</a>&nbsp;&nbsp;&nbsp;</td></tr>';
			}
			echo '</tbody></table></p><br><br>';
			echo '</div>';
		}
	?>
    </div>
    <?php } ?>
   </div>
  </div>
   <br> <br> <br>
</div>
</body>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
<?php if($login_session == "admin")
		foreach(array_keys(get_all_apps()) as $appid)
				echo "$('#".$appid."').DataTable({ 'columns': [ { 'width': '15%' },    null,    null,    null,    null  ] });";		
	 else
	 	{
			foreach(array_keys(get_apps($userid)) as $appid)
				echo "$('#".$appid."').DataTable({ 'columns': [ { 'width': '15%' },    null,    null,    null,    null  ] });";		
			echo "$('#assigned').DataTable({ 'columns': [ { 'width': '15%' },    null,    null,    null,    null  ] });";	
		}
		
	 
?>
});
</script>
</html>