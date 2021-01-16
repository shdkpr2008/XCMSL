<?php
include("info.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $app; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
    <style>
        body {
            margin: 0;
            padding: 0;
            position: relative;
            min-width: 900px;
            font-family: Helvetica Neue, Roboto, Arial, sans-serif;
        }
        iframe {
            width: 100%;
            height: 100%;
            display: block;
            border: none;
        }
        .devices {
            padding-bottom: 40px;
            overflow: hidden;
            width: 840px;
            margin-left: auto;
            margin-right: auto;
        }
        .device-ios {
            width: 320px;
            height: 548px;
            background: #111;
            border-radius: 55px;
            box-shadow: 0px 0px 0px 2px #aaa;
            padding: 105px 20px;
            position: relative;
            margin-right: 80px;
        }
        .device-ios:before {
            content: '';
            width: 60px;
            height: 10px;
            border-radius: 10px;
            position: absolute;
            left: 50%;
            margin-left: -30px;
            background: #333;
            top: 50px;
        }
        .device-ios:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            left: 50%;
            margin-left: -30px;
            bottom: 20px;
            border-radius: 100%;
            box-sizing: border-box;
            border: 5px solid #333;
        }
        .button {
            position: absolute;
            width: 200px;
            margin-left: -100px;
            left: 50%;
            top: -44px;
            margin-top: -30px;
            box-sizing: border-box;
            text-align: center;
            line-height: 44px;
            border-radius: 3px;
            text-decoration: none;
            color: blue;
            font-size: 14px;
        }
        .device-ios .button {
            border: 1px solid #007aff;
            color: #007aff;
        }
        .device-ios .button:active {
            background: rgba(0, 122, 255, 0.15);
        }
		.device-ios, .device-android {
            float: left;
        }
		.device-android {
            height: 640px;
            position: relative;
            padding: 60px 20px;
        }
    </style>
</head>
<body>
<div class="container">
<nav class="navbar ">
  <div class="container-fluid">
    <div class="navbar-header">
		<div id="nav-logo-container"></div>
    </div>
    <ul class="nav navbar-nav">
	  <li><a href="../index.php">Home</a></li>
    <?php  if($login_session == "admin") { ?>
      <li><a href="admin.php">Admin Panel</a></li>
    <?php } ?>
    </ul>
 </div>
</nav>
</div>
    <div class="devices">
        <div class="device device-ios">
            <iframe src="./home.php?appid=<?php echo $appid; ?>" scrolling="no" frameborder="0"></iframe>
        </div>
		 <div class="device device-android">
	        <img src="<?php echo $app_info["applogo"]; ?>" height="180px" width="200px" alt="Logo" ><br>
			<a href="<?php echo $app_info["ios"]; ?>"><i class="fa fa-apple fa-2x" aria-hidden="true"></i></a>
            <a href="<?php echo $app_info["android"]; ?>"><i class="fa fa-android fa-2x" aria-hidden="true"></i></a>
            <a href="<?php echo $app_info["fb"]; ?>"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
            <a href="<?php echo $app_info["twitter"]; ?>"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
            <a href="<?php echo $app_info["insta"]; ?>"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
            <a href="<?php echo $app_info["youtube"]; ?>"><i class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a>
        </div>
    </div>
</body>

</html>