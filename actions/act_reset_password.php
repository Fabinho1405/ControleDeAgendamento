<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$user = $_POST['user'];
	$token = $_POST['token'];
	$novasenha = $_POST['password'];

	//SELECT NO TOKEN
	$select_token = "SELECT * FROM token WHERE n_token = '$token' AND disponibilidade_token = '1' AND TIMESTAMPDIFF(SECOND, created, NOW()) < 60";
	$exec_select_token = mysqli_query($conn, $select_token);
	$qtd_select_token = mysqli_num_rows($exec_select_token);

	if($qtd_select_token == 1){
		//UPDATE DE SENHA
		$novasenha_crip = password_hash("$novasenha", PASSWORD_DEFAULT);
		$update_password = "UPDATE funcionario SET senha_func = '$novasenha_crip' WHERE cpf_func = '$user'";
		$exec_update_password = mysqli_query($conn, $update_password);
		//DESABILITA TOKEN
		$update_token = "UPDATE token SET disponibilidade_token = '0' WHERE n_token = '$token'";
		$exec_update_token = mysqli_query($conn, $update_token);
		//INSERE O LOG DO USO DO TOKEN
		//LOG                                   
                               $ip_log = $_SERVER['REMOTE_ADDR'];
                               $idfuncionario = $_SESSION['id_usuario'];
                               $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'Token utilizado para modificar senha| NTOK: $token | SIT: UTILIZADO', 'ALERTA', '$idfuncionario');";
                              $exec_insert_log = mysqli_query($conn, $insert_log);
        //FIM LOG
		//REDIRECIONA COM MENSAGEM DE SUCESSO
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
                                            Token Utilizado com Sucesso! Sua senha foi alterada.
                             </div>";
        header("Location:../loginpage.php");
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
                                            Token Incorreto ou Expirado !
                                    </div>";	
        header("Location:../loginpage.php");
	}



?>