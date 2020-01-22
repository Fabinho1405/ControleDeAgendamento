<!DOCTYPE html>
<html>
<head>
	<title>Ticket Médio</title>
</head>
<body>
	<center>
	<form name="ticketmeio" method="POST" action="">
		<label>Data Inicial:</label>
		<input type="date" name="datainicial">
		<br><br>
		<label>Data Final:</label>
		<input type="date" name="datafinal">
		<br><br>
		<input type="submit" name="puxarticket" value="Puxar Ticket!">
	</form>
	<br>
</center>
<center>Agendado / Reagendado / Ticket Médio</center>
	<hr>
</body>
</html>


<?php
	include_once("conection/conexao.php");

	if(isset($_POST['puxarticket'])){
	$data_inicial = $_POST['datainicial'];
	$data_final = $_POST['datafinal'];

	$data1 = new DateTime($data_inicial);
	$data2 = new DateTime($data_final);

	$intervalo = $data1->diff( $data2 );

	echo "<br> {$intervalo->d} dias de intervalo <BR>";
	$intervalo_final = $intervalo->d;
	$selecionar_func = "SELECT * FROM funcionario WHERE id_unidade = '4'";
	$selecionar_func_query = mysqli_query($conn, $selecionar_func);
	while($row_funcionario = mysqli_fetch_assoc($selecionar_func_query)){
		$id_func = $row_funcionario['id_func'];
		$pegar_qtd_agendados = "SELECT * FROM agendamentos WHERE id_func = '$id_func' AND id_unidade = '4' AND reagendado = '0' AND DATE(data_cadastro_agendamento) BETWEEN '$data_inicial' AND '$data_final'";
		$pegar_qtd_reagendados = "SELECT * FROM agendamentos WHERE id_func = '$id_func' AND id_unidade = '4' AND reagendado = '1' AND DATE(data_cadastro_agendamento) BETWEEN '$data_inicial' AND '$data_final'";
		$pegar_qtd_agendados_query = mysqli_query($conn, $pegar_qtd_agendados);
		$pegar_qtd_reagendados_query = mysqli_query($conn, $pegar_qtd_reagendados);
		$count_qtd_agendados = mysqli_num_rows($pegar_qtd_agendados_query);
		$count_qtd_reagendados = mysqli_num_rows($pegar_qtd_reagendados_query);
		$ticket_medio = $count_qtd_agendados / $intervalo_final;
		echo $row_funcionario['nome_completo_func'];
		echo " - ".$count_qtd_agendados." / ".$count_qtd_reagendados." / ".round($ticket_medio, 3)."<br>";


	}
}
?>