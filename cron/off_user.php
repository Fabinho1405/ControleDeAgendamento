<?php
	include_once("../conection/conexao.php");
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('H:i');
	echo $date."<br>";

	if($date > '21:30'){
		$desativar_contas = "UPDATE funcionario SET status_sistema = '0'";
		$exec_desativas_contas = mysqli_query($conn, $desativar_contas);
	}else{
		echo "Função impossível de ser efetuada!";
	}


	
		
	


?>