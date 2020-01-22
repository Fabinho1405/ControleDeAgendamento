#!/usr/local/bin/php
<?php
	
	include_once("../conection/conexao.php");
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('H:i');
	//echo $date."<br>";

	if($date > '09:50'){
		$desativar_contas = "UPDATE funcionario SET status_sistema = '1'";
		$exec_desativas_contas = mysqli_query($conn, $desativar_contas);
		echo "Efetuado";
	}else{
		echo "Função impossível de ser efetuada!";
	}


	
		
	


?>