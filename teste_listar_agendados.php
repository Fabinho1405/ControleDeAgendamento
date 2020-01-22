<!DOCTYPE html>
<html>
<head>
	<title>Listar Agendados</title>
</head>
<body>
		<center>
		<form name="pesquisar_agendamentos" action="" method="POST">
			<label>Data:</label>
			<input type="date" name="data_escolhida">
			<br><br>
			<label>Unidade:</label>
			<select name="select_unidade">
				<option value="1">Matriz</option>
				<option value="2">Lapa</option>
				<option value="3">Impact</option>
			</select>	
			<br><br>
			<input type="submit" name="enviar" value="Pesquisar">
		</form>
		</center>
		<hr>
		<?php
		include_once("conection/conexao.php");
		
		if(isset($_POST['enviar'])){

		$data_pesquisa = $_POST['data_escolhida'];
		$unidade = $_POST['select_unidade'];
		$select_agendamentos = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente INNER JOIN funcionario fun ON ag.id_func = fun.id_func WHERE data_agendada_agendamento = '$data_pesquisa' AND ag.id_unidade = '$unidade' AND fun.id_locado = '4'";
		$select_agendamentos_query = mysqli_query($conn, $select_agendamentos);

		?>
		<table border="1">
			<tr>
				<td><b>ID Ag</b></td>
				<td><b>ID Cli</b></td>
				<td><b>Nome Completo Modelo</b></td>
				<td><b>Responsável Modelo</b></td>
				<td><b>Horário Agendado</b></td>
				<td><b>Meio Captado</b></td>
				<td><b>Url Instagram</b></td>
				<td><b>Scouter</b></td>
				<td><b>Data de Cadastro</b></td>
			</tr>
			
	<?php

		while($row_agendamento = mysqli_fetch_assoc($select_agendamentos_query)){
			$instagram = $row_agendamento['url_instagram'];
	?>
	<tr>
		<td><?php echo $row_agendamento['id_agendamentos']; ?> </td>
		<td><?php echo $row_agendamento['id_cliente']; ?> </td>
		<td><?php echo $row_agendamento['nome_cliente']; ?> </td>
		<td><?php echo $row_agendamento['nome_responsavel_cliente']; ?> </td>
		<td><?php echo $row_agendamento['hora_agendada_agendamento']; ?> </td>
		<td><?php 
			if($row_agendamento['id_meio_captado'] == 1){
				echo "Instagram";
			}else if($row_agendamento['id_meio_captado'] == 2){
				echo "Whattsapp";
			}else if($row_agendamento['id_meio_captado'] == 3){
				echo "Ligação";
			}else{
				echo "N/E";
			}
		 

		?> </td>
		<td><?php 
			if(!empty($instagram)){
		  echo "<a href='http://www.instagram.com/$instagram' target='_blank'>Acessar</a>";
		}else{
			echo "N/P";
		}
		   ?> </td>
		<td><?php echo $row_agendamento['nome_completo_func']; ?> </td> 
		<td><?php echo $row_agendamento['data_cadastro_agendamento']; ?> </td>   
	</tr>
	<?php
		}
	}
	?>		
		</table>

</body>
</html>