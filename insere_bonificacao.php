<!DOCTYPE html>
<html>
<head>
	<title>Temporário Bonificação</title>
</head>
<body>
	<center>
	<form name="info_bonificacao" action="" method="POST">
		
		<label>Data:</label>
		<input type="date" name="data_calculo">
		<input type="submit" name="envio">		
	</form>
	</center>
	<hr>		
		<?php
			if(!empty($_POST['data_calculo'])){
				echo "<center>";
				echo "<font size='5px'>Data de Cálculo</font> <br>";
				echo $_POST['data_calculo'];
				echo "</center>";
			}else{
				echo "<center><font color='red'>Esperando Data</font></center>";
			}
		?>
	<hr>
	<center>
	<table border="1">
		<tr>
			<td><b> # </b></td>
			<td><b> Colaborador </b></td>
			<td><b> Agendados Ligação </b></td>
			<td><b> Bonus Ligacao </b></td>
			<td><b> Agendados Whatsapp</b></td>
			<td><b> Bonus Whatsapp </b></td>			
			<td><b> Agendados Instagram </b></td>
			<td><b> Bonus Instagram </b></td>
			<td><b> Bonificação Total </b></td>
		</tr>
		<?php
	include_once("conection/conexao.php");

	if(isset($_POST['envio'])){
	$pegar_todos_funcionarios = "SELECT * FROM funcionario;";
	$exec_pegar_todos_funcionarios = mysqli_query($conn, $pegar_todos_funcionarios);
	$data = $_POST['data_calculo'];

	while($row_func = mysqli_fetch_assoc($exec_pegar_todos_funcionarios)){
		$idfuncionario = $row_func['id_func'];

		$agendados_ligacao = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND DATE(data_cadastro_agendamento) = '$data'";
		$exec_agendados_ligacao = mysqli_query($conn, $agendados_ligacao);
		$agendados_wts = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '2'  AND DATE(data_cadastro_agendamento) = '$data'";
		$exec_agendados_wts = mysqli_query($conn, $agendados_wts);
		$agendados_insta = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1'  AND DATE(data_cadastro_agendamento) = '$data'";
		$exec_agendados_insta = mysqli_query($conn, $agendados_insta);		

		$qtd_agendados_ligacao = mysqli_num_rows($exec_agendados_ligacao);
		$qtd_agendados_wts = mysqli_num_rows($exec_agendados_wts);
		$qtd_agendados_insta = mysqli_num_rows($exec_agendados_insta);

		$meta_ligacao = '40';
		$meta_wts = '40';
		$meta_insta = '12';
		$valor_bonificacao = '0.50';

		if($qtd_agendados_ligacao <= $meta_ligacao){
			$final_ligacao = '0';
		}else{
			$semi_ligacao = $qtd_agendados_ligacao - $meta_ligacao;
			$final_ligacao = $semi_ligacao * $valor_bonificacao;

		};
		if($qtd_agendados_wts <= $meta_wts){
			$final_wts = '0';
		}else{
			$semi_wts = $qtd_agendados_wts - $meta_wts;
			$final_ligacao = $semi_wts * $valor_bonificacao;
		};
		if($qtd_agendados_insta <= $meta_insta){
			$final_insta = '0';
		}else{
			$semi_insta = $qtd_agendados_insta - $meta_insta;
			$final_insta = $semi_insta * $valor_bonificacao;
		}

		$id_funcio = $row_func['id_func'];
		$dinheiro_whatts = round($final_wts, 2);
		$dinheiro_ligacao = round($final_ligacao, 2);
		$dinheiro_instagram = round($final_insta, 2);

		
		$inserir_bonificacao = "INSERT INTO bonificacao (id_func, data_registro_bon, qtd_instagram_bon, qtd_wts_bon, qtd_lig_bon, din_instagram_bon, din_wts_bon, din_lig_bon, created ) VALUES ('$id_funcio','$data','$qtd_agendados_ligacao','$qtd_agendados_wts','$qtd_agendados_ligacao','$dinheiro_instagram','$dinheiro_whatts','$dinheiro_ligacao',NOW())";
		$exec_inserir_bonificacao = mysqli_query($conn, $inserir_bonificacao);
		



		
		echo "<tr>";
		echo "<td>".$row_func['id_func']."</td>";
		echo "<td>".$row_func['nome_completo_func']."</td>";
		echo "<td>".$qtd_agendados_ligacao."</td>";
		echo "<td>".round($final_ligacao, 2)."</td>";
		echo "<td>".$qtd_agendados_wts."</td>";
		echo "<td>".round($final_wts, 2)."</td>";
		echo "<td>".$qtd_agendados_insta."</td>";
		echo "<td>".round($final_insta, 2)."</td>";
		$total_bonificacao = $final_ligacao + $final_wts + $final_insta;
		echo "<td>".round($total_bonificacao, 2)."</td>";
		echo "</tr>";
		
	}
}else{

}
?>
	</table>
</center>
</body>
</html>

