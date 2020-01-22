<?php
	
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$btnLogin = filter_input(INPUT_POST, 'btn_login', FILTER_SANITIZE_STRING);
	$ip_log = $_SERVER['REMOTE_ADDR'];

	if($btnLogin){
		$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
		$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

		//echo "$usuario - $senha" ;

		if(!empty($usuario) AND !empty($senha)){
			//gerar senha cripto
			//echo password_hash("$senha", PASSWORD_DEFAULT);

			$result_validar = "SELECT * FROM funcionario WHERE CPF_func = '$usuario' LIMIT 1;";
			$resultado_validar = mysqli_query($conn, $result_validar);

			if($resultado_validar){
				$row_usuario = mysqli_fetch_assoc($resultado_validar); 

					if(password_verify($senha, $row_usuario['senha_func'])){
						if($row_usuario['status_sistema'] == 1){
							//VERIFICA SE O ULTIMO IP ACESSADO É O MESMO DO ATUAL
							if($ip_log == $row_usuario['ultimo_ip'] || $row_usuario['acesso_direto'] == 1){
							
								//GLOBAIS
								$tempolimite = 600; //equivale a 10 segundos
								$_SESSION['registro'] = time();
								$_SESSION['limite'] = $tempolimite;
								
								$_SESSION['id_usuario'] = $row_usuario['id_func']; 
								$_SESSION['nome_usuario'] = $row_usuario['CPF_func'];
								$_SESSION['nome_funcionario'] = $row_usuario['nome_completo_func'];
								$_SESSION['menu_scouter_ligacao'] = $row_usuario['menu_scouter_ligacao'];
								$_SESSION['menu_scouter_ligacao_new'] = $row_usuario['menu_scouter_ligacao_new'];
								$_SESSION['menu_scouter_insta'] = $row_usuario['menu_scouter_insta'];
								$_SESSION['menu_scouter_wts'] = $row_usuario['menu_scouter_wts'];
								$_SESSION['menu_scouter_face'] = $row_usuario['menu_scouter_face'];
								$_SESSION['menu_confirmacao'] = $row_usuario['menu_confirmacao'];
								$_SESSION['menu_supervisao'] = $row_usuario['menu_supervisao'];
								$_SESSION['menu_gerencia'] = $row_usuario['menu_gerencia'];
								$_SESSION['menu_recepcao'] = $row_usuario['menu_recepcao'];
								$_SESSION['menu_produtor'] = $row_usuario['menu_produtor'];
								$_SESSION['menu_edicao'] = $row_usuario['menu_edicao'];
								$_SESSION['menu_fotografo'] = $row_usuario['menu_fotografo'];
								$_SESSION['menu_gerente_agencia'] = $row_usuario['menu_gerente_agencia'];
								$_SESSION['menu_ligacao_interna'] = $row_usuario['menu_ligacao_interna'];
								$_SESSION['menu_auditoria'] = $row_usuario['menu_auditoria'];
								$_SESSION['menu_producao'] = $row_usuario['menu_producao'];
								$_SESSION['aut_financeiro'] = $row_usuario['aut_financeiro'];
								$_SESSION['permissao'] = $row_usuario['permissao'];
								$_SESSION['unidade'] = $row_usuario['id_unidade'];
								//LOG DE ACESSO AO SISTEMA
								$ip_log = $_SERVER['REMOTE_ADDR'];
								$idfuncionario = $_SESSION['id_usuario'];
									$insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'acessou o sistema', 'ALERTA', '$idfuncionario');";
									$exec_insert_log = mysqli_query($conn, $insert_log);
								//FIM DO LOG DE ACESSO
								//REGISTRAR IP AO LOGAR E O ÚLTIMO ACESSO
									$registra_ip = "UPDATE funcionario SET ultimo_ip = '$ip_log' WHERE id_func = '$idfuncionario'";
									$exec_registra_ip = mysqli_query($conn, $registra_ip);
								//
								//REGISTRA O PRIMEIRO ACESSO DO DIA
									$select_acesso = "SELECT * FROM funcionario WHERE date(primeiro_acesso_dia) <> date(NOW()) AND id_func='$idfuncionario'";
									$exec_select_acesso = mysqli_query($conn, $select_acesso);
									$nAcesso = mysqli_num_rows($exec_select_acesso);
									if($nAcesso >= 1){
										$update_primeiro="UPDATE funcionario SET primeiro_acesso_dia = NOW() WHERE id_func='$idfuncionario'";
										$exec_primeiro=mysqli_query($conn, $update_primeiro);
									}else{
										
									}
								
								header("Location: ../index.php");
							}else{
								$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
                                           Conta desativada por motivos de segurança. Entre em contato com seu supervisor.
                             </div>";
                             header("Location: ../loginpage.php");
                              //LOG DE ACESSO AO SISTEMA
							$ip_log = $_SERVER['REMOTE_ADDR'];						
							$insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'conta de usuario -> $usuario | Desativada por discrepancia de IP', 'PERIGO', 0);";
							$exec_insert_log = mysqli_query($conn, $insert_log);
						//FIM DO LOG DE ACESSO
							}
					}else{
						$_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
                                           Conta<b>Desativada</b> ! Entre em contato com o seu gestor para mais informações.
                             </div>";
                        //LOG DE ACESSO AO SISTEMA
						$ip_log = $_SERVER['REMOTE_ADDR'];
						$idfuncionario = $_SESSION['id_usuario'];
							$insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'conta restringida tentando acessar', 'ALERTA', 0);";
							$exec_insert_log = mysqli_query($conn, $insert_log);
						//FIM DO LOG DE ACESSO
							
						header("Location: ../loginpage.php");
					}
					}else{
						$_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Login e Senha INCORRETOS!
                             </div>";
                             //LOG DE ACESSO AO SISTEMA
						$ip_log = $_SERVER['REMOTE_ADDR'];						
							$insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'login ou senha incorretos', 'ALERTA', 0);";
							$exec_insert_log = mysqli_query($conn, $insert_log);
						//FIM DO LOG DE ACESSO
							
						header("Location: ../loginpage.php");
					}
			}


		}else{
			$_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Login e Senha INCORRETOS!
                             </div>";
             //LOG DE ACESSO AO SISTEMA
						$ip_log = $_SERVER['REMOTE_ADDR'];					
							$insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'login ou senha incorretos', 'ALERTA', 0);";
							$exec_insert_log = mysqli_query($conn, $insert_log);
			//FIM DO LOG DE ACESSO        
				      
		header("Location: ../loginpage.php");
		}
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
                                            Conecte-se corretamente ou contate o Suporte Tecnico central.
                             </div>";
         //LOG DE ACESSO AO SISTEMA
						$ip_log = $_SERVER['REMOTE_ADDR'];
					
							$insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'tentativa de acesso a pagina nao autorizada', 'PERIGO', 0);";
							$exec_insert_log = mysqli_query($conn, $insert_log);
						//FIM DO LOG DE ACESSO

		header("Location: ../loginpage.php");

	}


	


?>