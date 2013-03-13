<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agiva - Cliente</title>
    
	<meta charset="UTF-8">
    <meta name="author" content="Miguel Oliveira" />
    <meta name="description" content="Personal website" />
    
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico">
</head>

<body id="top">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
    <?
       	if(!isset($_SESSION['username']))
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">';
		else {
			include 'api/header.php';
			echo '<div class="container"><div class="clientInfo">';
			
			// show client info
			$db = new PDO("sqlite:dados.db");
			$select = "SELECT * FROM clientes WHERE id = '$_GET[clientID]'";
			
			if($query = $db->query($select)) {
				$result = $query->fetch(PDO::FETCH_ASSOC);

				echo "<h3>".$result['nome']."</h3>"
				, "<h4>NIF/NIPC: ".$result['nif'].'</h4>' // change to NIF or NIPC depending on the number
				, '<address>'.$result['morada'].'<br>'.$result['localidade'].'<br>'.$result['freguesia'].'<br>'.$result['postal'].'</address>'
				, '<span class="spacer"></span>';
			}

			// show his vehicles
			$select = "SELECT clientes.*, viaturas.*, impostos.dataLimitePagamento, impostos.idViatura FROM clientes, viaturas, impostos WHERE clientes.id = viaturas.idCliente AND viaturas.id = impostos.idViatura AND clientes.id = '$_GET[clientID]' ORDER BY impostos.dataLimitePagamento";
			
			if($query = $db->query($select)) {
				$result = $query->fetchAll(PDO::FETCH_ASSOC);

				echo '<table class="table table-hover table-condensed">'
				, '<tr><th>#</th><th>Marca</th><th>Modelo</th><th>Matrícula</th><th>Data Matrícula</th><th>Data limite</th><th>Tempo Restante</th><th></th></tr>';
				$var = 1;
				foreach ($result as $row) {
					echo '<tr><td>'.$var++.'</td>'
					, '<td>'.$row['marca'].'</td>'
					, '<td>'.$row['modelo'].'</td>'
					, '<td>'.$row['matricula'].'</td>'
					, '<td>'.substr($row['dataMatricula'],0,10).'</td>'
					, '<td>'.substr($row['dataLimitePagamento'],0,10).'</td>';

					if(strtotime($row['dataLimitePagamento']) < strtotime('now')) {
						echo '<td><span class="label label-important">Prazo ultrapassado</span></td>';
					}
					else {
						$days = round(abs(strtotime($row['dataLimitePagamento']) - strtotime('now'))/86400);
						if( $days <= 40 ) {
							echo '<td><span class="label label-warning">'.$days.' dias</span></td>';
						}
						else if( $days <= 60 ) {
							echo '<td><span class="label label-success">'.$days.' dias</span></td>';
						}
						else {
							echo '<td><span class="label label-info">'.$days.' dias</span></td>';
						}
					}

					echo '<td><div class="btn-group">'
					, 	'<button class="btn btn-inverse btn-mini">Opções</button>'
					,	'<button class="btn btn-inverse btn-mini dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>'
					, 	'<ul class="dropdown-menu">'
					,		'<li><a href="#" onclick="return changeTaxLimitDate('.$row['idViatura'].',1)"><i class="icon-ok"></i> Pago</a></li>'
					,		'<li><a href="#" onclick="return changeTaxLimitDate('.$row['idViatura'].',2)"><i class="icon-remove"></i> Não Pago</a></li>'
					,		'<li class="divider"></li><li><a href="#" onClick="return deleteTax(this)"><i class="icon-trash"></i> Eliminar</a></li>'
					,	'</ul></div></td>'
					, '</tr>';
				}
				echo '</table>';
			}
			echo '</div></div>';
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
