<?php
	$servidor = "51.79.99.148";
	$usario = "cda_Fabio";
	$senha = "Fabinho140598";
	$dbname = "cda_dbmodels";
	
	//Criar a conexao
	$conn = mysqli_connect($servidor,$usario,$senha,$dbname);
	

	
	//Checar a conexao
	if(!$conn){
		die("Falha na conexao com o banco: " . mysqli_connect_error());
	}else{
		//echo "Conexao realizada com sucesso";
	}
?>

	

