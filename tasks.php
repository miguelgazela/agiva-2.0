<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agiva - Tarefas</title>
	<meta charset="UTF-8">
    <meta name="author" content="Miguel Oliveira" />
    <meta name="description" content="Personal website" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico">
</head>

<body id="top" class="_tasks">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
    <?
       	if(!isset($_SESSION['username']))
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">';
		else {
			include 'api/header.php';
			echo '<div class="container">'
			,		'<div class="well" id="newTaskWell">'
            ,           '<a href="#newTask" role="button" onClick="return clearModal()"class="btn btn-large btn-block btn-success" data-toggle="modal">Adicionar Tarefa</a>'
            ,		'</div>';

            // modal of new task
            echo '<div id="newTask" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
            , '<div class="modal-header">'
            , 		'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>'
            , 		'<h3 id="myModalLabel">Nova tarefa</h3>'
            ,		'</div>'
            , '<div class="modal-body">'
            , 		'<textarea rows="4" class="btn-block"></textarea>' 
            ,		'<div class="control-group"><label class="control-label" for="inputDate"><i class="icon-calendar"></i> Data Limite (opcional)</label><input type="text" id="inputDate" placeholder="YYYY-MM-DD"><span class="help-inline"></span></div>'
            ,		'<label class="control-label" for="inputPriority"><i class="icon-exclamation-sign"></i> Prioridade (opcional)</label>'
            , 		'<div class="btn-group" data-toggle="buttons-radio">'
  			,			'<button type="button" class="btn btn-info">Baixa</button>'
  			,			'<button type="button" class="btn btn-success active">Normal</button>'
  			,			'<button type="button" class="btn btn-danger">Alta</button>'
			,		'</div>'
            , '</div>'
            , '<div class="modal-footer">'
            , 		'<button class="btn" id="cancelBtn" data-dismiss="modal" aria-hidden="true">Cancelar</button>'
            ,		'<button class="btn btn-primary" onClick="return addNewTask()">Guardar</button>'
            , '</div>'
            , '</div>';
			
			$db = new PDO("sqlite:dados.db");
			$username = $_SESSION['username'];
			$select = "SELECT * FROM tarefas WHERE user = '$username' ORDER BY prioridade";

			if($query = $db->query($select)) {
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				echo '<div class="away-from-top">';
				if(!empty($result)) {
					foreach($result as $row) {
                        if($row['prioridade'] == 3)
                            echo '<div class="alert alert-info fade in" id="'.$row['id'].'"><button type="button" onClick="return removeTask('.$row['id'].')" class="close" data-dismiss="alert">&times</button>'.$row['tarefa'].'</div>';
				        else if( $row['prioridade'] == 2)
                            echo '<div class="alert alert-success fade in" id="'.$row['id'].'"><button type="button" onClick="return removeTask('.$row['id'].')" class="close" data-dismiss="alert">&times</button>'.$row['tarefa'].'</div>';
                        else
                            echo '<div class="alert alert-error fade in" id="'.$row['id'].'"><button type="button" onClick="return removeTask('.$row['id'].')" class="close" data-dismiss="alert">&times</button>'.$row['tarefa'].'</div>';
                    }
				}
				echo '</div>';
			} else {
				// error
			}
			echo '</div>';
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
