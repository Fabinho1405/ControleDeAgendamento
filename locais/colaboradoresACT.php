<?php	
		include_once("../conection/connection.php");
		$pdo=conectar();

		$selectFunc=$pdo->prepare("SELECT * FROM funcionario ORDER BY id_func DESC");
		$selectFunc->execute();
		$linhaFunc=$selectFunc->fetchall(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ativar Contas</title>
</head>

<body>
	<table border="1">
		<tr>
			<td> ID </td>
			<td> Nome Completo </td>
			<td> Acesso Direto </td>
			<td> Ação </td>

		</tr>
	<?php
		foreach($linhaFunc as $rowFunc){
	?>
		<tr>
			<td><?php echo $rowFunc->id_func; ?></td>
			<td><?php echo $rowFunc->nome_completo_func; ?></td>
			<td><?php echo $rowFunc->acesso_direto; ?></td>
			<td>
				<?php
					$idFunc=$rowFunc->id_func;
					echo "<a href='actAtivaConta.php?id=$idFunc&proc=1'>Ativar Conta</a> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;";
					echo "<a href='actAtivaConta.php?id=$idFunc&proc=2'>Desativar Conta</a>";

				?>
			</td>
			

		</tr>
	<?php
		};
	?>
	</table>

</body>

</html>

