<?php
	session_start();
	ob_start();

	$idfuncionario = $_SESSION['id_usuario'];

	include_once("../conection/conexao.php");

	$conta_selecionada = $_POST['select_conta'];
	//$urlinsta = $_POST['urlinsta'];
	$data_agendado = $_POST['data_agendado'];
	$hora_agendado = $_POST['hora_agendado'];
	$iddocliente = $_GET['id'];
	//Cadastro em tabela Cliente
			date_default_timezone_set('America/Sao_Paulo');
			$dateatual = date('Y-m-d H:i');

				

		//header("Location: ../cadastrar_agendamento.php");


		//VALIDAÇÃO DE DADOS CONTRA FRAUDE
				if(!empty($data_agendado)){
					if(!empty($hora_agendado)){
							//INICIA O CADASTRO
						
						
						
							$result_cad_agendamento = "INSERT INTO `agendamentos` (`id_agendamentos`, `data_agendada_agendamento`, `hora_agendada_agendamento`, `data_cadastro_agendamento`, `id_conta_utilizada`, `id_cliente`, `id_meio_captado`, `id_status_auditoria`, `id_status_sistema`, `id_func`, `id_comparecimento`) VALUES (NULL, '$data_agendado', '$hora_agendado', '$dateatual', '$conta_selecionada', '$iddocliente', NULL, '1', '1', '$idfuncionario', '3');";

							$resultado_cad_agendamento = mysqli_query($conn, $result_cad_agendamento) or die($resultado_cad_agendamento);

							$_SESSION['msgcad'] = "<div class='alert alert-warning' role='alert'>
                                          <center> Agendamento Cadastrado com Sucesso! </center>";

							header("Location: ../cadastrar_agendamento.php");
							//FINALIZA O CADASTRO						
					}else{
						$_SESSION['msgcad'] = "<div class='alert alert-warning' role='alert'>
                                          <center> Preencha corretamente a  <b> Hora do Agendamento </b>! </center>";
                                           header("Location:../cadastrar_agendamento.php");
					}
				}else{
					$_SESSION['msgcad'] = "<div class='alert alert-warning' role='alert'>
                                          <center> Preencha corretamente a  <b> Data do Agendamento </b>! </center>";
                                           header("Location:../cadastrar_agendamento.php");
				}
?>