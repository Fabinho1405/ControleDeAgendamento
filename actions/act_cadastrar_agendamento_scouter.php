<?php
	session_start();
    ob_start();
	include_once("../conection/conexao.php");

	$conta_captada = $_POST['select_conta'];
	$nome_modelo = $_POST['nomecliente'];
	$idade = $_POST['idade_cliente'];
	$telefone_principal = $_POST['telefoneprincipal'];
	$telefone_secundario = $_POST['telefonesecundario'];
	$nome_responsavel = $_POST['responsavel'];
	$data_agendamento = $_POST['data_agendado'];
	$hora_agendamento = $_POST['hora_agendado'];
	$select_unidade = $_POST['select_unidade'];
	$idfuncionario = $_POST['select_scouter'];
	$url_instagram = $_POST['urlinsta'];


	if($conta_captada == 0){
		// AGENDAMENTO LIGAÇÃO
			 // Cadastrar o Cliente
                            $inserir_cliente = "INSERT INTO cliente (nome_cliente, telefone_cliente,telefone2_cliente,idade_cliente,nome_responsavel_cliente, id_meio_captado, data_cadastro_cliente,id_func) VALUES ('$nome_modelo','$telefone_principal','$telefone_secundario','$idade','$nome_responsavel','3',NOW(),'$idfuncionario')";
                            $inserir_cliente_resultado = mysqli_query($conn, $inserir_cliente);                       
                            // Procurar Novo Cliente
                            $procurar_cliente = "SELECT * FROM cliente WHERE nome_cliente = '$nome_modelo' AND telefone_cliente = '$telefone_principal'";
                            $procurar_cliente_resultado = mysqli_query($conn, $procurar_cliente);
                            $row_procurar_cliente = mysqli_fetch_assoc($procurar_cliente_resultado);
                            $id_new_cliente = $row_procurar_cliente['id_cliente'];

                            //Cadastrar Agendamento Com Novo Cliente
                            $data_agendamento_ajuste = date('Y-m-d', strtotime($data_agendamento));
                            $inserir_agendamento = "INSERT INTO agendamentos (id_agendamentos,data_agendada_agendamento,hora_agendada_agendamento,data_cadastro_agendamento,id_conta_utilizada,id_cliente, id_meio_captado, id_status_auditoria,id_status_sistema, id_func, id_comparecimento, id_unidade, confirmado) VALUES (NULL, '$data_agendamento_ajuste', '$hora_agendamento', NOW(), NULL, '$id_new_cliente', '3', '2', '1', '$idfuncionario', '3', '$select_unidade', '0')";
                            $inserir_agendamento_resultado = mysqli_query($conn, $inserir_agendamento);

                             $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
                             //LOG
                                $idfuncionarioacao = $_SESSION['id_usuario'];
                                $ip_log = $_SERVER['REMOTE_ADDR'];
                                $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'agendamento bruto LIG cadastrado | CLI: $id_new_cliente | FUNC: $idfuncionario', 'ALERTA', '$idfuncionarioacao');";
                                $exec_insert_log = mysqli_query($conn, $insert_log);
                            //FIM LOG

                            header("Location:../inserir_agendamento_scouter.php");
	}else{
		//AGENDAMENTO INSTAGRAM
							

							$inserir_cliente = "INSERT INTO cliente (nome_cliente, telefone_cliente,telefone2_cliente,nome_responsavel_cliente,email_cliente,url_instagram,data_cadastro_cliente,id_func, idade_cliente, id_meio_captado) VALUES ('$nome_modelo','$telefone_principal','$telefone_secundario','$nome_responsavel',NULL,'$url_instagram',NOW(),'$idfuncionario', '$idade', '1')";

                                $inserir_cliente_resultado = mysqli_query($conn, $inserir_cliente);
                               $procurar_cliente = "SELECT * FROM cliente WHERE nome_cliente = '$nome_modelo' AND telefone_cliente = '$telefone_principal'";

                                $procurar_cliente_resultado = mysqli_query($conn, $procurar_cliente);
                                $row_procurar_cliente = mysqli_fetch_assoc($procurar_cliente_resultado);
                                $id_new_cliente = $row_procurar_cliente['id_cliente']; 
                                $data_agendamento_ajuste = date('Y-m-d', strtotime($data_agendamento));
                                $inserir_agendamento = "INSERT INTO agendamentos (data_agendada_agendamento, hora_agendada_agendamento, data_cadastro_agendamento, id_cliente, id_status_sistema, id_func, id_comparecimento, id_conta_utilizada, id_unidade, id_meio_captado, id_status_auditoria) VALUES ('$data_agendamento_ajuste','$hora_agendamento',NOW(),'$id_new_cliente','1','$idfuncionario','3', '$conta_captada', '$select_unidade', '1', '1')";
                                $inserir_agendamento_resultado = mysqli_query($conn, $inserir_agendamento); 
                            $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
                             //LOG
                                $idfuncionarioacao = $_SESSION['id_usuario'];
                                $ip_log = $_SERVER['REMOTE_ADDR'];
                                $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'agendamento bruto INSTA enviado para auditoria | CLI: $id_new_cliente | FUNC: $idfuncionario', 'ALERTA', '$idfuncionarioacao');";
                                $exec_insert_log = mysqli_query($conn, $insert_log);
                            //FIM LOG


                            header("Location:../inserir_agendamento_scouter.php");



	}





?>