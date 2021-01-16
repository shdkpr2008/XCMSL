<?php
$xmlString;
if($_POST["xmlString"])
{
  $xmlString = $_POST["xmlString"];
  $xmlString  = str_replace(' xml:space=&apos;preserve&apos;', '', $xmlString);
	$xmlString = htmlspecialchars_decode($xmlString);
	$xmlString = stripslashes($xmlString);
	$XML = new SimpleXMLElement($xmlString);
?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
<meta charset="UTF-8">
<title>XCMSL Editor - Preview <?php echo $xmlFilename; ?></title>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function() {
	if($("#slideshow > div").length > 1)
	{
		$("#slideshow > div:gt(0)").hide();
		setInterval(function() {
		  $('#slideshow > div:first')
			.fadeOut(1000)
			.next()
			.fadeIn(1000)
			.end()
			.appendTo('#slideshow');
		}, 3000);
	}
});
</script>
<link href="css/live_editor.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="col-live">
    <!--	<div class="title">
        	<h3>Home</h3>
        </div> -->
        <div id="slideshow">
<?php      			
			$slides = array();
			foreach($XML->news->slideshow as $slideshow)
				 array_push($slides, (string)$slideshow->link);
 
			foreach($slides as $key => $value) { ?>
            <div>
                <img alt="Slideshow" height="165px" width="405px" src="<?php echo $value; ?>" />
                
               <!-- <a href="?dss_id=<?php echo $key; ?>"><span class="btn btn-danger btn-xs" style="float:right; margin-right:10px;">Remove Slideshow Image</span></a>  -->
            </div>
            <?php } ?>
        </div>
       <!-- <div id="new">
                <form style="width:380px;height:auto;" action="Untitled-1.php" method="post">
                 <div class="form-group">
                    <label for="imageurl">Image Url or &nbsp;<a style="float:right;" target="_blank" href="upload_image.php">Upload Images</a></label>
                    <input type="url" class="form-control" id="imageurl" placeholder="http://url-to-image">
                  </div>
		              <div class="form-group">
                   <button type="submit" class="btn btn-primary">Add Slideshow Image</button>                
                    </div>
               </form>
        </div>	  -->

        <div id="news">
        <?php 

		$news = array();
		foreach($XML->news->new as $value)
			array_push($news, (array)$value);

		foreach($news as $key => $new) { ?>
		 <hr>
        	<div id="new">
            	<div id="new_img"><img src="<?php echo $new["imageurl"]; ?>" /></div>
                <div id="new_content">
                	<span><strong><?php echo $new["titlenews"]; ?></strong></span><br>
					<p><?php echo substr($new["descnews"], 0, 80);  ?></p>
                    <span><?php echo $new["datenews"]; ?></span>
                    <!-- <a href="?dna_id=<?php echo $key; ?>"><span class="btn btn-danger btn-xs" style="float:right; margin-right:10px;">Remove</span></a>
                    <a href="?ena_id=<?php echo $key; ?>"><span class="btn btn-info btn-xs" style="float:right; margin-right:6px;">Edit</span></a>  -->
                </div>
        	</div>
	       
         <?php } //print_r($XML); ?>
         <!--	<div id="new">
                <form style="width:380px;height:auto;" action="./Untitled-1.php" method="post">
                  <div class="form-group">
                    <label for="titlenews">Title</label>
                    <input type="text" class="form-control" id="titlenews" placeholder="Title">
                  </div>
                  <div class="form-group">
                    <label for="descnews">Description</label>
                    <textarea class="form-control" id="descnews" rows="3" placeholder="Desctiption"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="imageurl">Image Url or &nbsp;<a style="float:right;" target="_blank" href="upload_image.php">Upload Images</a></label>
                    <input type="url" class="form-control" id="imageurl" placeholder="http://url-to-image">
                  </div>
                  <div class="form-group">
                    <label for="linknews">News Link</label>
                    <input type="url" class="form-control" id="linknews" placeholder="http://link-to-news">
                  </div>
                  <div class="form-group">
                    <label for="datenews">Date</label>
                    <input type="date" class="form-control" id="datenews" placeholder="http://">
                  </div>
                   <div class="form-group">
                   <button type="submit" class="btn btn-primary">Add</button>                
                    </div>
                </form>
              </div>
            </div>  -->
       <!-- <div id="tabs">
	        <a href="#"><div id="tab" class="home" name="home"><span>Home</span></div></a>
	        <a href="#"><div id="tab" class="home" name="home"><span>Picture</span></div></a>
	        <a href="#"><div id="tab" class="home" name="home"><span>Video</span></div></a>
	        <a href="#"><div id="tab" class="home" name="home"><span>&nbsp;Contact</span></div></a>
	        <a href="#"><div id="tab" class="home" name="home"><span>&nbsp;Maps</span></div></a>
        </div> -->
    </div>
	<!-- <div id="xml" style="display:none;"></div>
	<div id="actionButtons" style="display:none;">
		<div></div>
   		<button class="btn btn-success" id="save">Save Work</button>
	</div>  -->
    </div>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
</html>
<?php } ?>