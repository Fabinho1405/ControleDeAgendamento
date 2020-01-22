<?php
	
	include_once("../conection/conexao.php");

	$cliente = $_POST['palavra'];

	$cliente = "SELECT nome_cliente, telefone_cliente, telefone2_cliente FROM cliente WHERE nome_cliente LIKE '%$cliente%'";

	$resultado_cliente = mysqli_query($conn, $cliente);

	if(mysqli_num_rows($resultado_cliente) <= 0){
		echo "Nenhum curso encontrado";
	}else{
		echo "encontrado";
	}



?>