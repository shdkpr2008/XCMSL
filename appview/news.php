<?php
include("info.php");
libxml_use_internal_errors(true);
$app_file = $_GET["app_file"];
$id = $_GET["id"];
$dom = new DOMDocument(); 
$dom->preserveWhiteSpace = false;
$dom->load($app_file); 
$errors = libxml_get_errors();
$dom->formatOutput = true;
$XML = new SimpleXMLElement(stripslashes($dom->saveXML($dom->documentElement)));
$news = array();
foreach($XML->news->new as $value)
	array_push($news, (array)$value);
?>
<div class="navbar">
  <div class="navbar-inner">
    <div class="left"><a href="#" class="back link"> <i class="icon icon-back"></i><span>Back</span></a></div>
    <div class="center sliding"><?php echo $news[$_GET["id"]]["titlenews"]; ?></div>
  </div>
</div>
<div class="pages">
  <div data-page="about" class="page">
    <div class="page-content">
	  <img src="<?php echo $news[$_GET["id"]]["imageurl"]; ?>" alt="Slideshow" />
      <div class="content-block">
        <p><?php echo $news[$_GET["id"]]["descnews"]; ?></p>
      </div>
    </div>
  </div>
</div>