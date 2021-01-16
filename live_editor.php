<?php
include('session.php');
error_reporting(0);
$xmlString;
$xmlFilename;
$target;
if($appid = $_GET['appid'])
{
	$appname = get_app($appid)[$appid]["appname"];
	if(!array_key_exists($appid,get_apps($userid)) && $login_session != "admin")
	{
		echo "<script type='text/javascript'>window.location.href = 'index.php?error=Unauthorized Access to the app is not allowed!';</script>";	
		exit;
	}else
	{
		
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			//$xmlFilename = basename($_GET['xmlfile']);
			$xmlFilename = str_replace('../', '', $_GET['xmlfile']);
			$target = $app_dir.$appname."/".$xmlFilename;
			clearstatcache();
			if(!file_exists($target) || !filesize($target))
			{
				if(!is_dir(dirname($target)))
					mkdir(dirname($target), 0755);
				$customXML = new SimpleXMLElement('<xml><news><slideshow><link>Link Here</link></slideshow><new><imageurl></imageurl><titlenews></titlenews><descnews></descnews><linknews></linknews><datenews></datenews></new></news></xml>');
				$dom = dom_import_simplexml($customXML);
				file_put_contents($target, $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement));
			}
		}
	}
}
if (isset($_GET['xmlfile'])){
			$xmlFilename = str_replace('../', '', $_GET['xmlfile']);
			$target = $app_dir.$appname."/".$xmlFilename;
			$xml = simplexml_load_file($target, null, LIBXML_NOCDATA); // returns false if xml is invalid
}
?>

<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
<meta charset="UTF-8">
<title>XCMSL Editor - Editing <?php echo $xmlFilename; ?></title>
<link href="style.css" type="text/css" rel="stylesheet"/>
<style>
.editorContainer { float:left; position: relative; width: 62%; padding: 10px; margin: 0px auto; background-color: #ffffff; min-height: 350px; }
#editor { position: relative; }
#editor.laic { padding-left: 40px; }
.previewContainer { float:left; position: relative; width: 38%; padding: 10px; margin: 0px auto; background-color: #ffffff; min-height: 350px; }
</style>
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
  <div id="suc" style="display:none;" class="alert alert-success">Success!</div>
  <div id="err" style="display:none;" class="alert alert-danger">Failure!</div>
  
    <span><h2> Editing <?php echo $xmlFilename; ?> </h2></span>
  	<!--<div class="alert alert-warning">
  		<strong>Warning!</strong> Keep saving your work ! Click on-to <a target="_blank" href="upload_image.php">Upload Images</a>
	</div> --><br>
    <div id="actionButtons" style="display:none;">
    	<span><strong>Actions : </strong></span>
        <button class="btn btn-success" id="saveFile">Save Work</button>
		<a href="<?php echo $target; ?>"><button class='btn btn-success' id='viewFile'>View Raw XML File</button></a>
        <button class="btn btn-danger" id="deleteFile">Delete XML</button>
    </div><br>
    <div id="AppendButtons" style="display:none;">
 	   <span>Shortcuts : </span>
        <button class="btn btn-xs btn-warning" onClick='Xonomy.callMenuFunction(Xonomy.docSpec.elements["news"].menu[1], "xonomy2")'>Add a sliderImage</button>
    	<button class="btn btn-xs btn-warning" onClick='Xonomy.callMenuFunction(Xonomy.docSpec.elements["news"].menu[0], "xonomy2")'>Add a content</button>
    </div>
    <div id="xml">
        <div class="editorContainer">
            <div id="editor"></div>
        </div>
        <div class="previewContainer">
            <div id="preview"></div>
        </div>
    </div>
    </div>
</div>
<br><br>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="./plugin/xonomy.css"/>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="./plugin/xonomy.js"></script>
<script>
$(document).ready(function(){
	jQuery.browser = {};
	(function () {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();
<?php if (file_exists($target) && $xml){ ?>
		$("#actionButtons").show();	
		$("#AppendButtons").show();	
		$("button#saveFile").show().click(function(){
			/*var dialog = bootbox.dialog({
				title: 'Please wait while we are generating xml file...',
				message: '<p><i class="fa fa-spin fWa-spinner"></i> Loading...</p>',
				closeButton: false
			});*/
			
			var dialog = bootbox.dialog({ message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait while we are generating xml file...</div>' });
			
			$.ajax({
					type: "POST",
					dataType: "Json",
					url: "./do/saveXml.php",
					data: "appid=<?php echo $appid; ?>&xmlString="+encodeURIComponent(Xonomy.xmlEscape(Xonomy.harvest()))+"&xmlFilename=<?php echo $xmlFilename; ?>",
					success: function(response) {
						if(response.success == "true")
							{
								dialog.find('.bootbox-body').html('Saved the xml file!');
								setTimeout(function(){ dialog.modal('hide');}, 1500);
								$("#suc").show();
								setTimeout(function(){ $("#suc").hide(); }, 1500);
							}
						else
							{
								dialog.find('.bootbox-body').html('Error occured while saving the xml file!');
								setTimeout(function(){ dialog.modal('hide'); }, 1500);
								$("#err").show();
								setTimeout(function(){ $("#err").hide(); }, 1500);
							}
					}
				});
		});
		
		
			$("button#deleteFile").show().click(function(){

				var result = confirm("Do you want to delete this XML file? This cannot be undone.");

				if(result)
				{
					var dialog = bootbox.dialog({
						title: 'Please wait while we are deleting xml file...',
						message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>',
						closeButton: false
					});
					
					$.ajax({
							type: "POST",
							dataType: "Json",
							url: "./do/deleteXml.php",
							data: "appid=<?php echo $appid; ?>&xmlFilename=<?php echo $xmlFilename; ?>",
							success: function(response) {
								if(response.success == "true")
									{
										dialog.find('.bootbox-body').html('Deleted the xml file!');
										setTimeout(function(){ dialog.modal('hide');}, 1500);
										$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">Please link to a valid XML file, it looks like file is missing or is empty!</span> <br><br> <form action="#create_file" method="POST" class="form-inline"> <div class="form-group">  <label for="xmlfile">Do you want to create the missing file : </label>     <input type="text" class="form-control" id="xmlfile" value="<?php echo $target; ?>" readonly>   </div>   <button type="submit" class="btn btn-default">Yes</button> </form>').show();
										$("#actionButtons").hide();
										$("#AppendButtons").hide();	
										$("#suc").show();
										setTimeout(function(){ $("#suc").hide(); }, 1500);
									}
								else
									{
										dialog.find('.bootbox-body').html('Error occured while deleting the xml file!');
										setTimeout(function(){ dialog.modal('hide'); }, 1500);
										$("#err").show();
										setTimeout(function(){ $("#err").hide(); }, 1500);
									}
							}
						});
				}
		});
	
var docSpec={
	onchange: function(){
		jQuery.ajax({
		  type: "POST",
		  url: "./preview.php",
		  data: "xmlString="+encodeURIComponent(Xonomy.xmlEscape(Xonomy.harvest())),
		  success: function(response) {
			$('#preview').html(response);
		  }
		});
	},
	elements: {
		"news": {
			menu: [{
				caption: "Append a <Content>",
				action: Xonomy.newElementChild,
				actionParameter: "<new><imageurl></imageurl><titlenews></titlenews><descnews></descnews><linknews></linknews><datenews></datenews></new>"
				},
				{
				caption: "Append a <SliderImage>",
				action: Xonomy.newElementChild,
				actionParameter: "<slideshow><link></link></slideshow>"
				},
				]
			},
		"slideshow": {
			menu: [{
			caption: "Delete this <SliderImage>",
			action: Xonomy.deleteElement,
			},		{
			caption: "New <SliderImage> before this",
			action: Xonomy.newElementBefore,
			actionParameter: "<slideshow><link></link></slideshow>"
			}, {
			caption: "New <SliderImage> after this",
			action: Xonomy.newElementAfter,
			actionParameter: "<slideshow><link></link></slideshow>"
			}],
			canDropTo: ["news"],
			mustBeBefore: ["new"],
			title: "Slideshow",
			displayName: function(jsElement){
				try {
					 	if(jsElement.children[0].children[0].value == "")
							return "SliderImage empty";
						else
						{
						  var str = jsElement.children[0].children[0].value;
						  return "SliderImage "+str.substring(str.lastIndexOf('/') + 1);;
						}
						
					} catch(err) {
						return "SliderImage empty";
					}
			 },
			collapsed: function(jsElement){return true;},
			backgroundColour: "#ffd6d6",
			},
		"link": {
			asker: Xonomy.askString,
			hasText: true,
			oneliner: true,
			},
		"new": {
			menu: [{
			caption: "Delete this <Content>",
			action: Xonomy.deleteElement,
			},		{
			caption: "New <Content> before this",
			action: Xonomy.newElementBefore,
			actionParameter: "<new><imageurl></imageurl><titlenews></titlenews><descnews></descnews><linknews></linknews><datenews></datenews></new>"
			}, {
			caption: "New <Content> after this",
			action: Xonomy.newElementAfter,
			actionParameter: "<new><imageurl></imageurl><titlenews></titlenews><descnews></descnews><linknews></linknews><datenews></datenews></new>"
			}],
			canDropTo: ["news"],
			title: "Content",
			displayName: function(jsElement){
				try {
					 	if(jsElement.children[1].children[0].value == "")
							return "New Content";
						else
						 return jsElement.children[1].children[0].value;
						
					} catch(err) {
						return "New Content";
					}
				},
			mustBeAfter: ["slideshow"],
			collapsed: function(jsElement){return true;},
			backgroundColour: "#d6d6ff",
			},
		"imageurl": {
			hasText: true,
			asker: Xonomy.askString,
			oneliner: true,
			},
		"titlenews": {
			asker: Xonomy.askString,
			oneliner: true,
			hasText: true,
			},
		"descnews": {
			asker: Xonomy.askLongString,
			hasText: true,
			},
		"linknews": {
			asker: Xonomy.askString,
			hasText: true,
			oneliner: true,
			},
		"datenews": {
			asker: Xonomy.askString,
			oneliner: true,
			hasText: true,
			},
		}
};
	
//var xml=Xonomy.xmlEscape('<?php echo $XML; ?>');

$.ajax({
	type     : "GET",
	async    : false,
	url      : "<?php echo $target; ?>",
	dataType : "xml",
	error    : function(){ 
					$("#xml").html('Cannot find xml, try again!');
				 },
	success  : function(xml){
			   xml = new XMLSerializer().serializeToString(xml);
			   xml = xml.replace(/(\r\n|\n|\r)/gm,"").replace(/\s+/g, ' ').replace(/>\s*/g, '>').replace(/\s*</g, '<').trim();
			   var editor=document.getElementById("editor");
				Xonomy.render(xml, editor, docSpec);
				Xonomy.setMode("laic");
	}
});

$.ajax({
	
		  type: "POST",
		  url: "./preview.php",
		  data: "xmlString="+encodeURIComponent(Xonomy.xmlEscape(Xonomy.harvest())),
		  error    : function(){ 
					$("#preview").html('Cannot generate preview, try again!');
				 },
		  success: function(response) {
			$('#preview').html(response);
		  }	});
<?php } 
	else { ?>
	$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">Please link to a valid XML file, it looks like file is missing or is empty!</span> <br><br> <form action="#create_file" method="POST" class="form-inline"> <div class="form-group">  <label for="xmlfile">Do you want to create the missing file : </label>     <input type="text" class="form-control" id="xmlfile" value="<?php echo $target; ?>" readonly>   </div>   <button type="submit" class="btn btn-default">Yes</button> </form>').show();
	<?php
	 if (file_exists($target) && !$xml){ ?>
	$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">Please link to a valid XML file, it looks an invalid xml file!</span>').show();
	bootbox.dialog({ message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Linked file is not a valid XML and cannot be edited!</div>' });
	<?php } ?>
<?php } ?>
});
	
</script>
</body>
</html>