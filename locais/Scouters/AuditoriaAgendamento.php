<?php
	include_once("../../conection/connection.php");
	$pdo=conectar();

	$inicial=$_GET['dtInicial'];
	$final=$_GET['dtFinal']; 


?>
<!DOCTYPE html>
<html>
<head>
	<title>Solicitação de Agendamentos</title>
</head>
<body>
<?php
	$pesquisarClientes=$pdo->prepare("SELECT * FROM cliente WHERE date(data_cadastro_cliente) BETWEEN :dataInicial AND :dataFinal ORDER BY data_cadastro_cliente ASC");
	$pesquisarClientes->bindValue(":dataInicial", $inicial);
	$pesquisarClientes->bindValue(":dataFinal", $final);
	$pesquisarClientes->execute();

	$linhaCliente=$pesquisarClientes->fetchall(PDO::FETCH_OBJ);
	foreach($linhaCliente as $rowCliente){
		$agendamentosAtivos=$pdo->prepare("SELECT * FROM agendamentos WHERE id_cliente=:cliente AND id_status_sistema=1 ORDER BY data_cadastro_agendamento ASC");
		$agendamentosAtivos->bindValue(":cliente", $rowCliente->id_cliente);
		$agendamentosAtivos->execute();
		$qtdAgendamentosAtivos=$agendamentosAtivos->rowCount();
		if($qtdAgendamentosAtivos > 1){
			
			$linhaAgendamento=$agendamentosAtivos->fetch(PDO::FETCH_OBJ);

			echo "<center><h3>ID Cliente: ".$rowCliente->id_cliente."</h3></center>" ;
			echo "<center>MEIO CAPTADO: ".$rowCliente->id_meio_captado."</center>" ;
			echo "<center>QUANTIDADE DE AGENDAMENTOS: ". $qtdAgendamentosAtivos."</center><br>";
			//foreach($linhaAgendamento as $rowAgendamento){
				echo "<center>ID Agendamento: ".$linhaAgendamento->id_agendamentos."</center><br>";
				echo "<center>Status Sistema: ".$linhaAgendamento->id_status_sistema."</center><br>";
				echo "<center>Data Cadastro: ".date("d/m/Y H:i", strtotime($linhaAgendamento->data_cadastro_agendamento))."</center><br>";
				echo "<center>Data Agendada: ".date("d/m/Y", strtotime($linhaAgendamento->data_agendada_agendamento))."</center><br>";
				echo "<center>Hora Agendada: ".date("H:i", strtotime($linhaAgendamento->hora_agendada_agendamento))."</center><br>";
				echo "<center><h4><a href='desativarAgendamento.php?ag=".$linhaAgendamento->id_agendamentos."'> DESATIVAR </a></h4></center>";

					$updateAg=$pdo->prepare("UPDATE agendamentos SET id_status_sistema=0 WHERE id_agendamentos=:idAg");
					$updateAg->bindValue(":idAg", $linhaAgendamento->id_agendamentos);
					$updateAg->execute();

				echo "<center> **** </center>";
			echo "<center>--------------------------------------- </center><br>";
			//}
		}else{

		}	
			
	}



?>
</body>
</html>