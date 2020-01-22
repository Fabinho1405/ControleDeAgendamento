<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");


	$nomeconta = $_POST['nome_conta'];
	$idusuario = $_POST['idfunc'];

	//echo $nomeconta."<br>";
	//echo $idusuario."<br>";

	$inserir_conta = "INSERT INTO conta_utilizada (nome_conta_utilizada, rede_social_conta_utilizada, id_func, data_cadastro_conta_utilizada) VALUES ('$nomeconta','Instagram','$idusuario',NOW());";
	$inserir_conta_insta = mysqli_query($conn, $inserir_conta);
	//LOG
        $idfuncionario = $_SESSION['id_usuario'];
        $ip_log = $_SERVER['REMOTE_ADDR'];
        $idfuncionario = $_SESSION['id_usuario'];
        $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'conta do instagram adicionada->$nomeconta - FUNC -> $idusuario', 'ALERTA', '$idfuncionario');";
        $exec_insert_log = mysqli_query($conn, $insert_log);
	//FIM LOG

	header("Location:../cadastrar_insta_scouter.php");


?>