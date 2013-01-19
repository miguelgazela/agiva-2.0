<?php
	session_start();
	
	if(isset($_SESSION['username'])) {

		echo '<div class="navbar navbar-fixed-top navbar-inverse">'
		, 		'<div class="navbar-inner">'
		, 			'<div class="container">'
		, 				'<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">'
        , 					'<span class="icon-bar"></span>'
        , 					'<span class="icon-bar"></span>'
        , 					'<span class="icon-bar"></span>'
        , 				'</a>'
		, 				'<a class="brand" href="#">Agiva</a>'
		, 				'<div class="nav-collapse collapse">'
    	, 					'<ul class="nav">'
      	, 						'<li><a href="api/logout.php"><i class="icon-off icon-white"></i> logout</a></li>'
      	, 						'<li><a href="index.php" class="_taxes"><i class="icon-list icon-white"></i> Impostos</a></li>'
      	, 						'<li><a href="clients.php" class="_clients"><i class="icon-user icon-white"></i> Clientes</a></li>'
      	, 						'<li><a href="newClient.php" class="_newClient"><i class="icon-plus-sign icon-white"></i> Novo Cliente</a></li>'
      	,						  '<li><a href="newTax.php" class="_newTax"><i class="icon-plus-sign icon-white"></i> Novo Imposto</a></li>'
        ,             '<li><a href="tasks.php" class="_tasks"><i class="icon-list-alt icon-white"></i> Tarefas</a></li>'
    	, 					'</ul>'
    	, 				'</div>'
    	, 			'</div>'
    	,		'</div>'
    	, '</div>';
	}
	else
		die('ACCESS_DENIED');
?>