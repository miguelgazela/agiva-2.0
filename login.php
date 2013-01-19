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
			echo '<form id="loginForm">  
            	<div>  
                	<label for="username">Username</label>  
                	<input id="username" name="username" type="text" placeholder="username" onblur="validateUsername()" onkeyup="validateUsername()" />  
             		<span id="usernameInfo" class="hide"></span>  
            	</div>   
            		<div>  
                	<label for="pass">Password</label>  
               		<input id="pass" name="password" type="password" placeHolder="password" onblur="validatePass()" onkeyup="validatePass()" />  
                	<span id="passInfo" class="hide"></span>  
            	</div>   
            	<div>  
                	<input id="send" name="send" type="button" value="Login" onclick="login()" />  
            	</div>  
        	</form>';
		}
		else
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';	
	?>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script src="js/bootstrap.min.js"></script> 
</body>
</html>
