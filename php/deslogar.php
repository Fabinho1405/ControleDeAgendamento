<?php
    ob_start();
	session_start();

	include_once("../conection/conexao.php");
		//LOG
            $idfuncionario = $_SESSION['id_usuario'];
            $ip_log = $_SERVER['REMOTE_ADDR'];
            $idfuncionario = $_SESSION['id_usuario'];
            $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'deslogado do sistema', 'ALERTA', '$idfuncionario');";
            $exec_insert_log = mysqli_query($conn, $insert_log);
        //FIM LOG

        //REGISTRA O ULTIMO ACESSO DO USUÁRIO
            $insert_ultimo_acesso = "UPDATE funcionario SET ultimo_acesso = NOW() WHERE id_func = '$idfuncionario'";
            $exec_insert_ultimo_acesso = mysqli_query($conn, $insert_ultimo_acesso);

        // FIM REGISTRO
                                unset($_SESSION['registro']); 
                                unset($_SESSION['limite']);                                
                                unset($_SESSION['id_usuario']);
                                unset($_SESSION['nome_usuario']);
                                unset($_SESSION['nome_funcionario']);
                                unset($_SESSION['menu_scouter_ligacao']);
                                unset($_SESSION['menu_scouter_ligacao_new']);
                                unset($_SESSION['menu_scouter_insta']);
                                unset($_SESSION['menu_scouter_wts']);
                                unset($_SESSION['menu_scouter_face']);
                                unset($_SESSION['menu_confirmacao']);
                                unset($_SESSION['menu_supervisao']);
                                unset($_SESSION['menu_gerencia']);
                                unset($_SESSION['menu_recepcao']);
                                unset($_SESSION['menu_produtor']);
                                unset($_SESSION['menu_fotografo']);
                                unset($_SESSION['menu_gerente_agencia']);
                                unset($_SESSION['menu_ligacao_interna']);
                                unset($_SESSION['menu_auditoria']);
                                unset($_SESSION['aut_financeiro']);
                                unset($_SESSION['permissao']);
                                unset($_SESSION['unidade']);
                                unset($_SESSION['aut_contrato']);
                                unset($_SESSION['n_contrato']);
                                unset($_SESSION['pcdm']);



	$_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Deslogado com Sucesso!
                             </div>";
						header("Location:../loginpage.php");





?>