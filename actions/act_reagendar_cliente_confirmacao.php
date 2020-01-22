<?php
	include_once("../conection/conexao.php");
	session_start();
	ob_start();

	$idagendamento = $_GET['id'];
	$data_nova = $_POST['data_agendado'];
	$hora_nova = $_POST['hora_agendado'];
	$unidade_nova = $_POST['select_unidade'];
	$funcconf = $_SESSION['id_usuario'];

	//Informações do Antigo Agendamento
	$info_antigo = "SELECT * FROM agendamentos WHERE id_agendamentos = '$idagendamento'";
	$exec_info_antigo = mysqli_query($conn, $info_antigo);
	$row_antigo = mysqli_fetch_assoc($exec_info_antigo);

	$conta_utilizada = $row_antigo['id_conta_utilizada'];
	$id_cliente = $row_antigo['id_cliente'];
	$meio_captado = $row_antigo['id_meio_captado'];
	$idfuncionario = $row_antigo['id_func'];

	/*echo "ID AGENDAMENTO:";
	echo $idagendamento."<br>DATA NOVA:";
	echo $data_nova."<br> HORA NOVA:";
	echo $hora_nova."<br> UNIDADE NOVA:";
	echo $unidade_nova."<br> CONFIMAÇÃO FUNCIONARIO:";
	echo $funcconf."<br> CONTA UTILIZADA:";

	echo $conta_utilizada."<br> CLIENTE:";

	echo $id_cliente."<br> MEIO CAPTADO:";
	echo $meio_captado."<br> FUNCIONARIO AGENDOU:";
	echo $idfuncionario."<br>";
	*/
	
	//Inserir Novo Agendamento Atualizado

	$insere_novo = "INSERT INTO agendamentos (data_agendada_agendamento, hora_agendada_agendamento, data_cadastro_agendamento, id_conta_utilizada, id_cliente, id_func, id_meio_captado,
id_comparecimento, id_unidade, confirmado, reagendado, fbc_1, fbc_2, fbc_3, fbc_4, reagendado_conf, id_func_conf, id_status_sistema) VALUES ('$data_nova','$hora_nova', NOW() ,'$conta_utilizada','$id_cliente','$idfuncionario','$meio_captado','3','$unidade_nova','0','1','1','0','0','0','1', '$funcconf', '1')";

 	$exec_insere_novo = mysqli_query($conn, $insere_novo);

	header("Location:../");





?>