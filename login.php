<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agiva - Login</title>
    
	<meta charset="UTF-8">
    <meta name="author" content="Miguel Oliveira" />
    <meta name="description" content="Personal website" />
    
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>

<body>
    <?
       	if(!isset($_SESSION['username'])) {
            echo '<div class="container">'
            ,       '<div class="well" id="login">'
            ,           '<form class="form-signin">'
            ,               '<h2 class="form-signin-heading">Agiva</h2>'
            ,               '<input id="username" type="text" class="input-block-level error" placeholder="Username">'
            ,               '<input id="password" type="password" class="input-block-level" placeholder="Password">'
            ,               '<button class="btn btn-primary" type="button" onClick="return login()">Login</button>'
            ,           '</form>'
            ,'</div>';
		} else {
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';
        }	
	?>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-39261762-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script> 
</body>
</html>
