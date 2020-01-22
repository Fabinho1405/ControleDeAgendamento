<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
	$descricao_despesa = $_POST['desc_despesa'];
	$valor_despesa = $_POST['valor_despesa'];

	if($unidadefunc == 4){
		$insert_despesa = "INSERT INTO despesas_concept (descricao_despesa, valor_despesa, func_despesa, created_despesa) VALUES ('$descricao_despesa', '$valor_despesa', '$idfuncionario', NOW())";
		$exec_insert_despesa = mysqli_query($conn, $insert_despesa);
		 $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Despesa Inserida com Sucesso!</div>";
		header("Location:../lancar_despesas.php");

	}else if($unidadefunc == 1){
		$insert_despesa = "INSERT INTO despesas_exclusive (descricao_despesa, valor_despesa, func_despesa, created_despesa) VALUES ('$descricao_despesa', '$valor_despesa', '$idfuncionario', NOW())";
		$exec_insert_despesa = mysqli_query($conn, $insert_despesa);
		 $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Despesa Inserida com Sucesso!</div>";
		header("Location:../lancar_despesas.php");
	}
	


?>