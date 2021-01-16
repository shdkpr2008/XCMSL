<?php
include('session.php');
error_reporting(0);
$xmlString;
$xmlFilename;
$target;
if($_SERVER["REQUEST_METHOD"] == "POST") {
      // filename to create sent from form 
      
      //$xmlFilename = basename($_GET['xmlfile']);
	  $xmlFilename = str_replace('../', '', $_GET['xmlfile']);
	  if(!array_key_exists($appid,get_apps($userid)) && $login_session != "admin")
	  	{
			$target = $xml_dir.$xmlFilename;
			clearstatcache();
			if(!file_exists($target) || !filesize($target))
				{
					$customXML = new SimpleXMLElement('<xml><node></node></xml>');
					$dom = dom_import_simplexml($customXML);
						if(!is_dir(dirname($target))){
						//Directory does not exist, so lets create it.
						mkdir(dirname($target), 0755);
						}
					file_put_contents($target, $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement));
					
				}
		}
}
if (isset($_GET['xmlfile'])){
    $xmlFilename = str_replace('../', '', $_GET['xmlfile']);
	$target = $xml_dir.$xmlFilename;
	$xml = simplexml_load_file($target, null, LIBXML_NOCDATA); // returns valse if xml is invalid
	if ($xml) $xmlString = $xml->asXML();
}
?>
<!DOCTYPE html>
<html dir="auto" lang="en">
<head>
<meta charset="UTF-8">
<title>XCMSL Editor - Editing <?php echo $xmlFilename; ?></title>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();
</script>
<script type="text/javascript" src="js/ext/jquery-color.js"></script>
<script type="text/javascript" src="js/ext/GLR/GLR.js"></script>
<script type="text/javascript" src="js/ext/GLR/GLR.messenger.js"></script>
<script type="text/javascript" src="js/loc/xmlEditor.js"></script>
<link href="css/main.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
$(document).ready(function(){
<?php if (file_exists($target) && $xml){ ?>
	//Generate Tree
	GLR.messenger.show({msg:"Loading XML..."});
	console.time("loadingXML");
	xmlEditor.loadXmlFromFile("<?php echo $target; ?>", "#xml", function(){
		console.timeEnd("loadingXML");
		$("#xml").show();
		$("#actionButtons").show();																																				
		xmlEditor.renderTree();
		$("button#deleteFile").show().click(function(){
			bootbox.confirm({
				title: "Delete XML?",
				message: "Do you want to delete this XML file? This cannot be undone.",
				buttons: {
					cancel: {
						label: '<i class="fa fa-times"></i> Cancel'
					},
					confirm: {
						label: 'Delete XML',
						className: 'btn-danger'
					}
				},
				callback: function (result) {
					console.log('This was logged in the callback: ' + result);
					if(result)
					{
						var dialog = bootbox.dialog({
							title: 'Please wait while we are deleting xml file...',
							message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>',
							closeButton: false
						});

						 $.post("do/deleteXml.php", {xmlFilename:"<?php echo $xmlFilename; ?>"}, function(data){
						if (data.error){
							//GLR.messenger.show({msg:data.error,mode:"error"});
							dialog.find('.bootbox-body').html('Error occured while deleting the xml file!'+ data.error);
							setTimeout(function(){
										dialog.modal('hide');
									}, 1500);
						}
						else {
							//GLR.messenger.inform({msg:"Deleted the xml file!", mode:"success"});
							dialog.find('.bootbox-body').html('Deleted the xml file!');
							setTimeout(function(){
										dialog.modal('hide');
									}, 1500);
							if ($("button#viewFile").length){
								$("button#viewFile").hide();
							}
							$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">Please link to a valid XML file, it looks like file is missing or is empty!</span> <br><br> <form action="#create_file" method="POST" class="form-inline"> <div class="form-group">  <label for="xmlfile">Do you want to create the missing file : </label>     <input type="text" class="form-control" id="xmlfile" value="<?php echo $target; ?>" readonly>   </div>   <button type="submit" class="btn btn-default">Yes</button> </form>').show();
							$("#actionButtons").hide();
						}
					});
											
					}
				}
			});
		});
		
		 $("button#editFile").hide().click(function(){
			$('#treeView').hide();
			$('#treeView').html("<li></li>");
			$('#xml').show();
			$('button#viewFile').show();
			$('button#editFile').hide();
		 });
		 $("button#viewFile").show().click(function(){
			$('#xml').hide();
			$('#treeView').show();
			$('button#viewFile').hide();
			$('button#editFile').show();
			

			function IsValidImageUrl(url,node,tree) {
				var img = new Image();
				img.onerror = function() { $('<ul><li>'+$(tree).text()+'<\/li><\/ul>').appendTo(node); }
				img.onload =  function() { $('<ul><li><img height="400px" width="400px" src="'+$(tree).text()+'"><\/li><\/ul>').appendTo(node); }
				img.src = url
			}

			function traverse(node,tree) {
				var children=$(tree).children()
				node.append(tree.nodeName)
				if (children.length){
					var ul=$("<ul>").appendTo(node)
					children.each(function(){
						var li=$('<li>').appendTo(ul)
						traverse(li,this)
					})
				}else{
					IsValidImageUrl($(tree).text(),node,tree);
				}
			}
			
			//Generate Preview
			var tree = $.parseXML(xmlEditor.getXmlAsString());
			traverse($('#treeView li'),tree.firstChild)
			$('<b>–<\/b>').prependTo('#treeView li:has(li)').click(function(){
				var sign=$(this).text()
				if (sign=="–")
					$(this).text('+').next().children().hide()
				else
					$(this).text('–').next().children().show()
			});
		});
				
		$("button#saveFile").show().click(function(){
			//GLR.messenger.show({msg:"Generating file...", mode:"loading"});
			var dialog = bootbox.dialog({
				title: 'Please wait while we are generating xml file...',
				message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>',
				closeButton: false
			});
			$.post("do/saveXml.php", {xmlString:xmlEditor.getXmlAsString(), xmlFilename:"<?php echo $xmlFilename; ?>"}, function(data){
				
				if (data.error){
					//GLR.messenger.show({msg:data.error,mode:"error"});
					dialog.find('.bootbox-body').html('Error occured while saving the xml file!'+ data.error);
					setTimeout(function(){
								dialog.modal('hide');
							}, 1500);
				}
				else {
					//GLR.messenger.inform({msg:"Saved the xml file!", mode:"success"});
					dialog.find('.bootbox-body').html('Saved the xml file!');
					setTimeout(function(){
								dialog.modal('hide');
							}, 1500);
					if (!$("button#viewFile").length){
						$("<button class='btn btn-success' id='viewFile'>View Updated File</button>")
							.appendTo("#actionButtons div")
							.click(function(){ window.open("<?php echo $target; ?>"); });
					}
				}
			});
		});
	});
<?php } 
	else if (!in_array($xmlFilename,explode(",",$user_info[$login_session][1])) && $login_session != "admin")
	{?>
	$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">You are not allowed to access such file!</span>').show();			
<?php }
	else { ?>
	$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">Please link to a valid XML file, it looks like file is missing or is empty!</span> <br><br> <form action="#create_file" method="POST" class="form-inline"> <div class="form-group">  <label for="xmlfile">Do you want to create the missing file : </label>     <input type="text" class="form-control" id="xmlfile" value="<?php echo $target; ?>" readonly>   </div>   <button type="submit" class="btn btn-default">Yes</button> </form>').show();
	<?php
	 if (file_exists($target) && !$xml){ ?>
	$("#xml").html('<span style="font:italic 15px georgia,serif; color:#f30;">Please link to a valid XML file, it looks an invalid xml file!</span>').show();
	GLR.messenger.showAndHide({msg:"Linked file is not a valid XML and cannot be edited!", mode:"error", speed:3000});
	<?php } ?>
<?php } ?>
});
</script>
</head>
<body>
<div class="container">
<nav class="navbar ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" >Welcome <?php echo $login_session; ?></a>
    </div>
    <ul class="nav navbar-nav">
	  <li><a href="index.php">Home</a></li>
    <?php  if($login_session == "admin") { ?>
      <li><a href="admin.php">Admin Panel</a></li>
    <?php } ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  <div class="row">
  <div class="col-sm-12 col-md-10 col-md-offset-1">
  	<div class="alert alert-warning">
  		<strong>Warning!</strong> Changes are reflected as you save or delete the file, make sure to backup! <br>
		Click on-to <a target="_blank" href="upload_image.php">Upload Images</a>
	</div>
  	<h2> Editing <?php echo $xmlFilename; ?> </h2>
    <br>
    <ul id="treeView" style="display: none;">
        <li></li>
    </ul>
	<div id="xml" style="display:none;"></div>
	<div id="actionButtons" style="display:none;">
		<div></div>
   		<button class="btn btn-success" id="saveFile">Save XML</button>
		<button class="btn btn-info" id="viewFile">View XML</button>
        <button class="btn btn-info" id="editFile">Edit XML</button>
		<button class="btn btn-danger" id="deleteFile">Delete XML</button>
	</div>
    </div>
</div>
<br><br>
</div>
<?php if ($xmlString){ ?><textarea style="display:none;" id="xmlString"><?php echo $xmlString; ?></textarea><?php } ?>
</body>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
</html>