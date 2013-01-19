<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agiva</title>
	<meta charset="UTF-8">
    <meta name="author" content="Miguel Oliveira" />
    <meta name="description" content="Personal website" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico">
</head>

<body id="top" class="_taxes">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
    <?
       	if(!isset($_SESSION['username']))
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">';
		else {
			include 'api/header.php';
			echo '<div class="container">'
			, '<script type="text/javascript">loadPage()</script>'
			, '</div>';
		}
	?>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
