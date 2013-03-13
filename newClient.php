<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agiva - Adicionar novo cliente</title>
    
	<meta charset="UTF-8">
    <meta name="author" content="Miguel Oliveira" />
    <meta name="description" content="Personal website" />

    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico">
</head>

<body id="top" class="_newClient">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <?
       	if(!isset($_SESSION['username']))
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">';
		else {
			include 'api/header.php';
			echo '<div class="container">'
			,	'<form class="form-horizontal away-from-top" id="newClient">'
            ,		'<div class="control-group">'
            ,           '<label class="control-label" for="inputName">Nome Cliente</label>'
            ,			'<div class="controls">'
            ,               '<input type="text" id="newClientName" placeholder="Nome Cliente">'
            ,               '<span class="help-inline"></span>'
            ,           '</div>'
            ,       '</div>'
            ,       '<div class="control-group">'
            ,           '<label class="control-label" for="inputAddress">Morada</label>'
            ,           '<div class="controls">'
            ,               '<input type="text" id="newClientAddress" placeholder="Morada">'
            ,               '<span class="help-inline"></span>'
            ,           '</div>'
            ,       '</div>'
            ,       '<div class="control-group">'
            ,           '<label class="control-label" for="inputLocal">Localidade</label>'
            ,           '<div class="controls">'
            ,               '<input type="text" id="newClientLocal" placeholder="Localidade">'
            ,               '<span class="help-inline"></span>'
            ,           '</div>'
            ,       '</div>'
            ,       '<div class="control-group">'
            ,           '<label class="control-label" for="inputParish">Freguesia</label>'
            ,           '<div class="controls">'
            ,               '<input type="text" id="newClientParish" placeholder="Freguesia">'
            ,               '<span class="help-inline"></span>'
            ,           '</div>'
            ,       '</div>'
            ,       '<div class="control-group">'
            ,           '<label class="control-label" for="inputPostal">Código Postal</label>'
            ,           '<div class="controls">'
            ,               '<input type="text" id="newClientPostal" placeholder="Código Postal">'
            ,               '<span class="help-inline"></span>'
            ,           '</div>'
            ,       '</div>'
            ,       '<div class="control-group">'
            ,           '<label class="control-label" for="inputNIF">NIF/NIPC</label>'
            ,           '<div class="controls">'
            ,               '<input type="text" id="newClientNIF" placeholder="NIF/NIPC">'
            ,               '<span class="help-inline"></span>'
            ,           '</div>'
            ,       '</div>'
            ,       '<div class="controls">'
            ,           '<button type="button" class="btn btn-success" onClick="return addNewClient(1)">Adicionar</button>'
            ,           '<button type="reset" class="btn" onClick="return resetForm()">Apagar</button>'
            ,       '</div>'
            ,	'</form>';
		}
	?>
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
