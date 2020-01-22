 <?php
	include_once("../../conection/connection.php");
	$pdo=conectar();

	$idCliente=$_GET['cli'];

	//Informações para Adicionar
	$nCaso="5";
	$problema="Ligando para o cliente repetidas vezes no mesmo dia.";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Informações</title>
</head>
<body>
	<h2><b>** Caso Número: <?php echo $nCaso; ?>**</b></h2>
	<label>Problema: <?php echo $problema; ?></label>

	<?php
		$pesquisaCliente=$pdo->prepare("SELECT * FROM cliente cli INNER JOIN funcionario func ON cli.id_func = func.id_func WHERE cli.id_cliente=:cliente");
		$pesquisaCliente->bindValue(":cliente", $idCliente);
		$pesquisaCliente->execute();
		$linhaCliente=$pesquisaCliente->fetchall(PDO::FETCH_OBJ);




		foreach($linhaCliente as $rowCliente){
	?>
		<h2><b>-- CLIENTE --</b></h2>
		<label>ID do Cliente: </label> <?php echo $rowCliente->id_cliente; ?> <br>
		<label>Nome do Cliente: </label> <?php echo $rowCliente->nome_cliente; ?> <br>
		<label>Telefone Principal Cliente: </label> <?php echo $rowCliente->telefone_cliente; ?> <br>
		<label>Telefone Secundário Cliente: </label> <?php echo $rowCliente->telefone2_cliente; ?> <br>
		<label>Idade Cliente: </label> <?php echo $rowCliente->idade_cliente; ?> <br>
		<label>Captação Inicial: </label> <?php if($rowCliente->id_meio_captado == 1){ echo "Instagram"; }elseif($rowCliente->id_meio_captado == 3){ echo "Ligação"; }else{ echo "Nenhum Meio Cadastrado Encontrado."; }; ?> <br>
		<label>Data de Cadastro do Cliente: </label> <?php echo date("d/m/Y - H:i:s", strtotime($rowCliente->data_cadastro_cliente)); ?> <br>
		<label>Funcionário de Captação: </label> <?php echo $rowCliente->nome_completo_func; ?>

		<h2><b>-- AGENDAMENTOS -- </b></h2>
	<?php
		$agendamentosCliente=$pdo->prepare("SELECT * FROM agendamentos ag INNER JOIN funcionario func ON ag.id_func = func.id_func WHERE ag.id_cliente=:cliente ORDER BY data_cadastro_agendamento ASC");
		$agendamentosCliente->bindValue(":cliente", $rowCliente->id_cliente);
		$agendamentosCliente->execute();
		$linhaAgendamentoCliente=$agendamentosCliente->fetchall(PDO::FETCH_OBJ);

		foreach($linhaAgendamentoCliente as $rowAgendamento){
	?>
		<label>Identificação do Agendamento: </label><?php echo $rowAgendamento->id_agendamentos;  ?><br>
		<label>Status em Sistema: </label><?php echo $rowAgendamento->id_status_sistema;  ?><br>
		<label>Data de Cadastro: </label> <?php echo date("d/m/Y - H:i:s", strtotime($rowAgendamento->data_cadastro_agendamento)); ?><br>
		<label>Data Agendada Agendamento: </label> <?php echo date("d/m/Y", strtotime($rowAgendamento->data_agendada_agendamento))." - ".date("H:i", strtotime($rowAgendamento->hora_agendada_agendamento));  ?> <br>
		<label>Meio Captado do Agendamento: </label> <?php if($rowAgendamento->id_meio_captado == 1){ echo "Instagram"; }elseif($rowAgendamento->id_meio_captado == 3){ echo "Ligação"; }else{ echo "Nenhum Meio Cadastrado Encontrado."; };  ?><br>
		<label>Funcionário do Agendamento: </label><?php echo $rowAgendamento->nome_completo_func; ?><br>
		<label>Unidade de Agendamento: </label><?php if($rowAgendamento->id_unidade == 1){echo "Exclusive";}elseif($rowAgendamento->id_unidade == 4){echo "Concept";}else{echo "Nenhum Meio Cadastrado Encontrato";}; ?><br>
		<label>Reagendado: </label> <?php echo $rowAgendamento->reagendado; ?> <br>
		<label>Confirmado: </label> <?php if($rowAgendamento->confirmado == 1){echo "Agendamento Confirmado"; }elseif($rowAgendamento->confirmado == 0){ echo "Agendamento Não Confirmado"; }; ?><br>
		<label>Compareceu: </label> <?php if($rowAgendamento->id_comparecimento == 1){echo "Sim"; }elseif($rowAgendamento->id_comparecimento == 3){ echo "Não Compareceu"; }; ?><br>

		<label>Liberado Para Recuperação: </label><?php if($rowAgendamento->dataLiberadaRecuperacao <> ""){echo "Sim - ".date("d/m/Y H:i:s", strtotime($rowAgendamento->dataLiberadaRecuperacao)); }else{ echo "Não";} ?><br>
		<?php
			$funcRecuperacao=$pdo->prepare("SELECT * FROM funcionario WHERE id_func=:func");
			$funcRecuperacao->bindValue(":func", $rowAgendamento->func_recuperacao);
			$funcRecuperacao->execute();
			$rowRecuperacao=$funcRecuperacao->fetch(PDO::FETCH_OBJ);
		?>
		<label>Funcionário da Recuperação: </label> <?php echo $rowRecuperacao->nome_completo_func; ?>


		<br>
		<label>--------------------------------------------------------------</label>
		<br>

	<?php
		};
		};


	?>

</body>
</html>