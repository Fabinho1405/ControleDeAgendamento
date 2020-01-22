<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idagendamento = $_GET['idagdm'];

	$select__modificar_cliente = "SELECT * FROM agendamentos WHERE id_agendamentos = '$idagendamento'";
	$exec_select_modificar_cliente = mysqli_query($conn, $select__modificar_cliente);
	$row_cliente = mysqli_fetch_assoc($exec_select_modificar_cliente);
	$nomecliente = $row_cliente['nome_cliente'];

	echo "<form name='' method='POST' action=''>";
	echo "Cliente: <input type='text' name='nomecliente' value=''><br>";
	echo "Responsável: <input type='text' name='responsavelcliente' value=''>";
	echo "</form>";


?>