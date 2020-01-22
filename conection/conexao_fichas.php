<?php
	$servidor = "localhost";
	$usario = "root";
	$senha = "";
	$dbname = "dbfichas";
	
	//Criar a conexao
	$conn = mysqli_connect($servidor,$usario,$senha,$dbname);
	
	//Checar a conexao
	if(!$conn){
		die("Falha na conexao com o banco: " . mysqli_connect_error());
	}else{
		//echo "Conexao realizada com sucesso";
	}
?>