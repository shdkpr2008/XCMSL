<?php 
libxml_use_internal_errors(true);
$dom = new DOMDocument(); 
$dom->preserveWhiteSpace = false;
$dom->load($file); 
$errors = libxml_get_errors();
$dom->formatOutput = true;
if(empty($errors))
{
$XML = new SimpleXMLElement(stripslashes($dom->saveXML($dom->documentElement)));
$news = array();
foreach($XML->news->new as $value)
	array_push($news, (array)$value);

	if(isset($_GET["id"]))
	{
		$title = $title." - ".$news[$_GET["id"]]["titlenews"];
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
	if($("#da-slider > div").length > 1)
	{
		$("#da-slider > div:gt(0)").hide();
	setInterval(function() {
	  $('#da-slider > div:first')
		.fadeOut(1000)
		.next()
		.fadeIn(1000)
		.end()
		.appendTo('#da-slider');
		}, 3000);
	}
});
</script>	
<link href="wstyle.css" type="text/css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
</head>

<body>
<header class="header">
<div class="logo_l" style="background-image:url(<?php echo $app_info["logo_left"]; ?>);background-position:center;background-size:contain;"></div>
<nav class="navbar navbar-custom">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li class="active"><a href="./inicio.php?appid=<?php echo $appid; ?>"><strong>INICIO</strong></a></li>
      <li><a href="./conexion.php?appid=<?php echo $appid; ?>"><strong>conexión </strong></a></li>
      <li><a href="./nosotros.php?appid=<?php echo $appid; ?>"><strong>NOSTROS</strong></a></li>
      <li><a href="./eventos.php?appid=<?php echo $appid; ?>"><strong>EVENTOS</strong></a></li>
      <li><a href="./contacto.php?appid=<?php echo $appid; ?>"><strong>CONTACTO</strong></a></li>
    </ul>
    </div>
  </div>
</nav>
<div class="logo_r" style="background-image:url(<?php echo $app_info["logo_right"]; ?>);background-position:center;background-size:contain;"></div>
</header>
	<?php 
	if(isset($_GET["id"]))
	{ ?>
  <div class="container">
  <div class="row">
      <div class="col-sm-12 col-md-8 col-md-offset-2">
      <div id="da-slider" class="da-slider" style="min-height:400px !important;">
		<div class="da-slide">
			<img src="<?php echo $news[$_GET["id"]]["imageurl"]; ?>" alt="Slideshow" />
		 </div>
        </div>
       </div>
      </div>
      </div>
	<?php } else { ?>
  <div class="container">
  <div class="row">
      <div class="col-sm-12 col-md-10 col-md-offset-1">
    <div id="da-slider" class="da-slider">
    <?php $slides = array();
    foreach($XML->news->slideshow as $slideshow)
         array_push($slides, (string)$slideshow->link);

    foreach($slides as $key => $value) { ?>
     <div class="da-slide">
        <img src="<?php echo $value; ?>" alt="Slideshow" />
    </div>
    <?php }
	?> </div></div></div></div> <?php } ?>

<div class="container">
  <div class="row">
			<?php if(isset($_GET["id"])) { ?>
      <div class="col-sm-12 col-md-8 col-md-offset-2">
      	<div class="row">
          <div id="news">
			<h1><?php echo $news[$_GET["id"]]["titlenews"]; ?></h1>	
             <p style="margin:0 0 10px 10px;"><?php echo $news[$_GET["id"]]["descnews"]; ?></p>   
             <!--<span><?php echo $news[$_GET["id"]]["datenews"]; ?></span>-->
             </div>
         </div>
      </div>
			<?php	
			} else  { ?>
      <div class="col-sm-12 col-md-10 col-md-offset-1">
      	<div class="row">
          <div id="news">
			<?php foreach($news as $key => $new) { ?>
                <div id="new" onclick="location.href='<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>';">
                    <div id="new_img"><img src="<?php echo $new["imageurl"]; ?>" /></div>
                    <div id="new_content">
                        <span id="title"><strong><?php echo $new["titlenews"]; ?></strong></span><br>
                        <p><?php echo substr($new["descnews"], 0, 200);  ?></p>
                        <!--<span><?php echo $new["datenews"]; ?></span>-->
                    </div>
                </div>
             <?php }?>
             </div>
         </div>
      </div>
             <?php }?>
  </div>
</div>
<footer class="footer">
<nav class="navbar ">
	<div class="container">
    <div class="row">
    <div class="col-sm-12 col-md-10 col-md-offset-1" style="padding-left:0 !important;">
        <div id="nav-logo-container"></div><p class="navbar-text pull-left">Copyright Notice</p>
            <div class="nav navbar-nav navbar-right nav-custom">
                <a href="<?php echo $app_info["ios"]; ?>"><i class="fa fa-apple fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo $app_info["android"]; ?>"><i class="fa fa-android fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo $app_info["fb"]; ?>"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo $app_info["twitter"]; ?>"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo $app_info["insta"]; ?>"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo $app_info["youtube"]; ?>"><i class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a>
            </div>
       </div>
       </div>
    </div>
</nav>
</footer>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
</html>
<?php } else { ?>
<p><strong>Missing or invalid linked xml file!</strong></p>
<?php } ?>