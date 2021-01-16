<?php
require_once "config.php" ;
session_start();
session_destroy();   
?>
<html>
<head>
	<meta name="google-signin-client_id" content="<?php echo $gscid; ?>">
</head>
<body>
<script>
    function signOut() {
      var auth2 = gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        window.location.href = 'login.php';
      });
    }
    function onLoad() {
      gapi.load('auth2', function() {
        gapi.auth2.init().then(function () { 
		signOut();
		});
      });
	  window.location.href = 'login.php';
    }
	
</script>
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
</body>
</html>