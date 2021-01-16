<?php
include("info.php");
libxml_use_internal_errors(true);
$inicio = $app_dir.$appname."/".$app_info["inicio"];
$conexión = $app_dir.$appname."/".$app_info["conexión"];
$eventos = $app_dir.$appname."/".$app_info["eventos"];
$nosotros = $app_dir.$appname."/".$app_info["nosotros"];
$contacto = $app_dir.$appname."/".$app_info["contacto"];
$files = array("1" => $inicio, "2" => $conexión, "3" => $eventos, "4" => $nosotros, "5" => $contacto);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>My App</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="./css/framework7.ios.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="./css/my-app.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
	$(function() {
	<?php foreach($files as $num => $file) {  ?>
		if($("#slideshow-<?php echo $num; ?> > div").length > 1)
		{
			$("#slideshow-<?php echo $num; ?> > div:gt(0)").hide();
			setInterval(function() {
			  $('#slideshow-<?php echo $num; ?> > div:first')
				.fadeOut(1000)
				.next()
				.fadeIn(1000)
				.end()
				.appendTo('#slideshow-<?php echo $num; ?>');
			}, 3000);
		}
	<?php }	?>
	});
    </script>
  </head>
  <body>
    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>
    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views tabs toolbar-through">
    <?php foreach($files as $num => $file) { 
		$dom = new DOMDocument(); 
		$dom->preserveWhiteSpace = false;
		$dom->load($file); 
		$errors = libxml_get_errors();
		$dom->formatOutput = true;
		$XML = new SimpleXMLElement(stripslashes($dom->saveXML($dom->documentElement)));
	?>
      <div id="view-<?php echo $num; ?>" class="view tab <?php if($num == "1") echo "active"; ?>">
        <!-- We can make with view with navigation, lets add Top Navbar-->
        <div class="navbar">
          <div class="navbar-inner">
            <div class="center sliding"><?php switch($num) { 
			case "1" : echo "Inicio"; break; 
			case "2" : echo "Conexión"; break;
			case "3" : echo "Nostros"; break;
			case "4" : echo "Eventos"; break;
			case "5" : echo "Contacto"; break;
			 }  ?></div>
          </div>
        </div>
        <div class="pages navbar-through">
          <div data-page="index-<?php echo $num; ?>" class="page">
            <div class="page-content">
                <div class="col-live">
                    <div id="slideshow-<?php echo $num; ?>">
						<?php
                        $slides = array();
                        foreach($XML->news->slideshow as $slideshow)
                        	array_push($slides, (string)$slideshow->link);
                         
                        foreach($slides as $key => $value) { ?>
                        <div>
                        	<img alt="Slideshow" height="165px" width="100%" src="<?php echo $value; ?>" />
                        </div>
                        <?php } ?>
                     </div><br>
                     <div id="news">
                        <?php 
                       	$news = array();
                        foreach($XML->news->new as $value)
                          array_push($news, (array)$value);
                          
                        foreach($news as $key => $new) { ?>
                        <a href="<?php echo "./news.php?app_file=".$file."&id=".$key; ?>" class="item-link"><div id="new">
                        	<div id="new_img"><img src="<?php echo $new["imageurl"]; ?>" /></div>
                            <div id="new_content">
                            <p><span><strong id="title"><?php echo $new["titlenews"]; ?></strong></span><br><?php echo substr($new["descnews"], 0, 60);  ?></p>
                            </div>
                        </div></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <!-- Bottom Tabbar-->
      <div class="toolbar tabbar tabbar-labels">
        <div class="toolbar-inner">
        <a href="#view-1" class="tab-link active"><i class="icon tabbar-demo-icon-1"></i><span class="tabbar-label">Inicio</span></a>
        <a href="#view-2" class="tab-link"><i class="icon tabbar-demo-icon-2"></i><span class="tabbar-label">Conexiones</span></a>
        <a href="#view-3" class="tab-link"><i class="icon tabbar-demo-icon-3"></i><span class="tabbar-label">Blog</span></a>
        <a href="#view-4" class="tab-link"> <i class="icon tabbar-demo-icon-4"></i><span class="tabbar-label">Nostros</span></a>
		<a href="#view-5" class="tab-link"> <i class="icon tabbar-demo-icon-5"></i><span class="tabbar-label">Contacto</span></a>
        </div>
      </div>
    </div>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="./js/framework7.min.js"></script>
    <!-- Path to your app js-->
    <script type="text/javascript" src="./js/my-app.js"></script>
  </body>
</html>