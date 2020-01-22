<?php
	session_start();
	ob_start();
	$idfuncionario = $_SESSION['id_usuario'];

	include_once("../conection/conexao.php");



	$nome_cliente = $_POST['nome_completo'];
	$datanascimento_cliente = $_POST['data_nascimento'];
	$nomeresponsavel_cliente = $_POST['responsavel'];
	$email_cliente = $_POST['email'];
	$orientacao_cliente = $_POST['sexo'];
	$telefone_cliente = $_POST['telefone'];
	$telefone2_cliente = $_POST['telefone2'];
	$meiocaptado_cliente = $_POST['meio_captado'];

	// Verificar dados que saem do form 
	//echo $nome_cliente." <br /> ".$datanascimento_cliente." <br /> ".$nomeresponsavel_cliente." <br /> ".$email_cliente." <br /> ".$orientacao_cliente." <br /> ".$telefone_cliente." <br /> ".$telefone2_cliente." <br /> ".$meiocaptado_cliente;

	//echo "<br /> REALIZADO COM SUCESSO";


	//VERIFICAÇÕES ANTI FRAUDE
	if(!empty($nome_cliente)){
		if(!empty($datanascimento_cliente)){
			if(!empty($nomeresponsavel_cliente)){
				if(!empty($orientacao_cliente)){
					if(!empty($telefone_cliente)){
						if(!empty($telefone2_cliente)){
							if(!empty($meiocaptado_cliente)){
								$query_result_fraude = "SELECT `nome_cliente`,`telefone_cliente`, `telefone2_cliente` FROM cliente WHERE telefone_cliente = '$telefone_cliente' OR telefone2_cliente = '$telefone_cliente';";
								$result_verificar_fraude = mysqli_query($conn, $query_result_fraude);
								$resultado_verificar_fraude = mysqli_num_rows($result_verificar_fraude);
									if($resultado_verificar_fraude == 1){
										$result_cadastrar_cliente = "INSERT INTO cliente (id_cliente, nome_cliente, telefone_cliente, telefone2_cliente, data_nascimento_cliente, nome_responsavel_cliente, email_cliente,sexo_cliente, id_meio_captado, id_func , alerta_fraude, data_cadastro_cliente) VALUES (DEFAULT, '$nome_cliente', '$telefone_cliente', '$telefone2_cliente', '$datanascimento_cliente', '$nomeresponsavel_cliente', '$email_cliente', '$orientacao_cliente', '$meiocaptado_cliente', '$idfuncionario', 1, NOW());";
									 	$resultado_cadastrar_cliente = mysqli_query($conn, $result_cadastrar_cliente);
									 	$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                         Cliente Cadastrado com <b> SUCESSO! </b>
								                                         (ALTF_1)
								                             </div>";
								        header("Location: ../cadastrar_cliente.php");
								    }else{
								    	$query_result_fraude = "SELECT `nome_cliente`,`telefone_cliente`, `telefone2_cliente` FROM cliente WHERE telefone_cliente = '$telefone2_cliente' OR telefone2_cliente = '$telefone2_cliente';";
										$result_verificar_fraude2 = mysqli_query($conn, $query_result_fraude2);
										$resultado_verificar_fraude2 = mysqli_num_rows($result_verificar_fraude2);
										if($resultado_verificar_fraude2 == 1){
											$result_cadastrar_cliente = "INSERT INTO cliente (id_cliente, nome_cliente, telefone_cliente, telefone2_cliente, data_nascimento_cliente, nome_responsavel_cliente, email_cliente,sexo_cliente, id_meio_captado, id_func , alerta_fraude, data_cadastro_cliente) VALUES (DEFAULT, '$nome_cliente', '$telefone_cliente', '$telefone2_cliente', '$datanascimento_cliente', '$nomeresponsavel_cliente', '$email_cliente', '$orientacao_cliente', '$meiocaptado_cliente', '$idfuncionario', 1, NOW());";
									 		$resultado_cadastrar_cliente = mysqli_query($conn, $result_cadastrar_cliente);
									 		$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                         Cliente Cadastrado com <b> SUCESSO! </b>
								                                         (ALTF_1)
								                             </div>";
								                            header("Location: ../cadastrar_cliente.php");


								    	}else{
								    		$result_cadastrar_cliente = "INSERT INTO cliente (id_cliente, nome_cliente, telefone_cliente, telefone2_cliente, data_nascimento_cliente, nome_responsavel_cliente, email_cliente,sexo_cliente, id_meio_captado, id_func , alerta_fraude, data_cadastro_cliente) VALUES (DEFAULT, '$nome_cliente', '$telefone_cliente', '$telefone2_cliente', '$datanascimento_cliente', '$nomeresponsavel_cliente', '$email_cliente', '$orientacao_cliente', '$meiocaptado_cliente', '$idfuncionario', 0, NOW());";
									 		$resultado_cadastrar_cliente = mysqli_query($conn, $result_cadastrar_cliente);
									 		$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                         Cliente Cadastrado com <b> SUCESSO! </b>
								                             </div>";
								                        	header("Location: ../cadastrar_cliente.php");
																
						}
					}}else{
								$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Preencha o Meio Captado </b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
							}
						}else{
							$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Preencha o Telefone 2 do Cliente </b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
						}
					}else{
						$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Preencha o Telefone do Cliente </b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
					}
				}else{
					$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Preencha o Sexo do Cliente </b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
				}
			}else{
				$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Preencha o Nome do Responsável</b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
			}
		}else{
			$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Preencha Data de Nascimento do Cliente </b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
		}
	}else{
		$_SESSION['msg_cad'] = "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'>
								                                        <b> Selecione o Cliente </b>
								                             </div>";
								header("Location: ../cadastrar_cliente.php");
	}
?>