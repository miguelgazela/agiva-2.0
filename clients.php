<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agiva - Clientes</title>
	<meta charset="UTF-8">
    <meta name="author" content="Miguel Oliveira" />
    <meta name="description" content="Personal website" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico">
</head>

<body id="top" class="_clients">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
    <?
       	if(!isset($_SESSION['username']))
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">';
		else {
			include 'api/header.php';
			echo '<div class="container" id="clientList">';
			
			$db = new PDO("sqlite:dados.db");
			$select = "SELECT id, nome, nif FROM clientes ORDER BY nome";

			if($query = $db->query($select)) {
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				echo '<table class="table table-hover table-condensed">'
				, '<tr><th>#</th><th>Nome</th><th>NIF</th><th></th></tr>';
				$var = 1;
				foreach($result as $row) {
					echo '<tr><td>'.$var++.'</td>'
					, '<td><a href="client.php?clientID='.$row['id'].'">'.$row['nome'].'</a></td><td>'.$row['nif'].'</td>'
					, '<td><div class="btn-group">'
					, 	'<button class="btn btn-inverse btn-mini">Opções</button>'
					,	'<button class="btn btn-inverse btn-mini dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>'
					, 	'<ul class="dropdown-menu">'
					,		'<li><a href="client.php?clientID='.$row['id'].'">Ver perfil</a></li>'
					,		'<li class="divider"></li><li><a href="#">Eliminar</a></li>'
					,	'</ul></div></td></tr>';

				}
				echo '</table>';
			}
			
			//, '<p class="warning hide">Não há impostos na base de dados</p>'
			echo '</div>';
		}
	?>
	<script src="js/bootstrap.min.js"></script>      
</body>
</html>
