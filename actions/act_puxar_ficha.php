<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idfuncionario = $_SESSION['id_usuario'];
	$unidadefunc = $_SESSION['unidade'];


	//DADOS DO FORMULÁRIO
	$colaborador = $_POST['idcolaborador'];
	$quantidade = $_POST['qtd_fichas'];


	//PUXAR FICHA
	$puxar_ficha = "UPDATE controle_ligacao SET id_func = '1' WHERE id_func = '$colaborador' AND id_status_sistema = '1' AND id_extracao = '0' AND liberado_controle_externo = '0'  AND date(data_liberada_stand_by) <> date(NOW()) ORDER BY qtd_feedback ASC LIMIT $quantidade ";
	$exec_puxar_ficha = mysqli_query($conn, $puxar_ficha);
	header("Location:../liberar_recuperacao.php");

?>