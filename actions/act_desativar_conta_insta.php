<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$idconta = $_POST['idconta'];
	

	$desativar_conta = "UPDATE conta_utilizada SET status = '0' WHERE id_conta_utilizada = '$idconta'";
	$exec_desativar_conta = mysqli_query($conn, $desativar_conta);
	$select_nome_conta = "SELECT * FROM conta_utilizada ca INNER JOIN funcionario fun ON ca.id_func = fun.id_func WHERE ca.id_conta_utilizada = '$idconta'";
	$exec_select_nome_conta = mysqli_query($conn, $select_nome_conta);
	$row_conta = mysqli_fetch_assoc($exec_select_nome_conta);
	$nomeconta = $row_conta['nome_conta_utilizada'];
	$pertencia = $row_conta['nome_completo_func'];
	$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Conta Desativada com Sucesso!
                                    </div>";
    //LOG
        $idfuncionario = $_SESSION['id_usuario'];
        $ip_log = $_SERVER['REMOTE_ADDR'];
        $idfuncionario = $_SESSION['id_usuario'];
        $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'conta do instagram removida->$nomeconta -func->$pertencia', 'ALERTA', '$idfuncionario');";
        $exec_insert_log = mysqli_query($conn, $insert_log);
	//FIM LOG

    header("Location: ".$_SERVER['HTTP_REFERER']."");

?>