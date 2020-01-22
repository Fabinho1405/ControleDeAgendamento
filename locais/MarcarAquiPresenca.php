<?php

	include_once("../conection/connection.php");
	$pdo=conectar();


	$dataPres=$_GET['dataConfirmacao'];
	$unidadePres=$_GET['unidade'];

	$pesquisarAgendamentos=$pdo->prepare("SELECT * FROM agendamentos ag INNER JOIN funcionario func ON ag.id_func = func.id_func INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente WHERE ag.data_agendada_agendamento=:dataAgendada AND ag.id_unidade=:unidade ORDER BY func.nome_completo_func ASC");
	$pesquisarAgendamentos->bindValue("dataAgendada", $dataPres);
	$pesquisarAgendamentos->bindValue(":unidade", $unidadePres);
	$pesquisarAgendamentos->execute();

	$linhaAgendamentos=$pesquisarAgendamentos->fetchall(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Marca Aqui</title> 
</head>
<body>
	<center>
	<table border="1">
		<tr>
			<td><b>ID</b></td>
			<td><b>Nome Cliente</b></td>
			<td><b>Responsável</b></td>
			<td><b>Telefone</b></td>
			<td><b>Telefone 2</b></td>
			<td><b>Scouter</b></td>
			<td><b>Ação</b></td>
		</tr>
<?php
		foreach($linhaAgendamentos as $rowAgend){
		echo "<tr>"; 
		echo "<td> ".$rowAgend->id_agendamentos."</td>";
		echo "<td> ".$rowAgend->nome_cliente."</td>";
		echo "<td> ".$rowAgend->nome_responsavel_cliente."</td>";
		echo "<td> ".$rowAgend->telefone_cliente."</td>";
		echo "<td> ".$rowAgend->telefone2_cliente."</td>";
		echo "<td> ".$rowAgend->nome_completo_func."</td>";
		if($rowAgend->id_comparecimento <> 1){
			echo "<td> <a href='registraPresenca.php?ID=".$rowAgend->id_agendamentos."&UNID=".$unidadePres."'>COMPARECEU</a></td>";
		}else{
			echo "<td> JÁ MARCADO </td>";
		}
		echo "</tr>";

	}

?>
		
	</table>
</center>
</body>
</html>