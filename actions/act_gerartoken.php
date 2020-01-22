<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idtoken = $_POST['idtoken'];
	$motivo = $_POST['motivo_token'];

	
	do{
		$tokenfinal = rand(1000000000,100000000000);
		$verif_exitencia_token = "SELECT * FROM token WHERE n_token = '$tokenfinal'";
		$exec_verif_existencia_token = mysqli_query($conn, $verif_exitencia_token);
		$qtd_existencia_token = mysqli_num_rows($exec_verif_existencia_token);
		if($qtd_existencia_token <> 0){
			$cad_ok = 0;
		}else{
			$cad_ok = 1;
		}
	}while($cad_ok <> 1);
	$idfuncionario = $_SESSION['id_usuario'];
	$insert_token = "INSERT INTO token (n_token, motivo_token, desc_token, disponibilidade_token, id_func, created) VALUES ('$tokenfinal','$idtoken', '$motivo', 1, '$idfuncionario', NOW())";
	$exec_insert_token = mysqli_query($conn, $insert_token);
	//LOG
        $idfuncionario = $_SESSION['id_usuario'];
        $ip_log = $_SERVER['REMOTE_ADDR'];
        
        $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'Gerou um Token. MOT: $motivo | IDTOKEN:$idtoken', 'ALERTA', '$idfuncionario');";
        $exec_insert_log = mysqli_query($conn, $insert_log);
	//FIM LOG
	$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                            Token Gerado com Sucesso! Acesse o Histórico.
                             </div>";
	header("Location:../gerar_token.php");



?>