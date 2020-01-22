<?php
	include_once("conection/conexao.php");
	$dia_confirmacao = '1998-05-14';
	$unidade_confirmacao = '1';

	$confirmacao_p_tentativa = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade_confirmacao' AND fbc_1 <> '2' AND fbc_1 = '1' ";
	$confirmacao_p_tentativa_query = mysqli_query($conn, $confirmacao_p_tentativa);
	$qtd_confirmacao_p_tentativa = mysqli_num_rows($confirmacao_p_tentativa_query);
	if($qtd_confirmacao_p_tentativa > 0){
		//EFETUA PRIMEIRO CONTATO DE CONFIRMAÇÃO
		while($row_conf = mysqli_fetch_assoc($confirmacao_p_tentativa_query)){
			echo "<tbody>";
			echo "<tr>";
			echo "<td>".$row_conf['id_agendamentos']."</td>";
			echo "<td>".$row_conf['id_cliente']."</td>";
			echo "<td>".$row_conf['data_agendada_agendamento']."</td>";
			echo "<td>".$row_conf['hora_agendada_agendamento']."</td>";
			echo "<td>".$row_conf['hora_agendada_agendamento']."</td>";
			echo "<td>".$row_conf['hora_agendada_agendamento']."</td>";
			echo "<td>".$row_conf['hora_agendada_agendamento']."</td>";
			echo "<td>".$row_conf['hora_agendada_agendamento']."</td>";
			echo "</tr>";
			echo "</tbody>";
		
		}
	}else{
		$confirmacao_s_tentativa = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade_confirmacao' AND fbc_2 <> '2' AND fbc_2 = '0' ";
		$confirmacao_s_tentativa_query = mysqli_query($conn, $confirmacao_s_tentativa);
		$qtd_confirmacao_s_tentativa = mysqli_num_rows($confirmacao_s_tentativa_query);
		if($qtd_confirmacao_s_tentativa > 0){
			while($row_conf = mysqli_fetch_assoc($confirmacao_s_tentativa_query)){
		
			echo $row_conf['id_agendamentos']."<br>";
			echo $row_conf['id_cliente']."<br>";
			echo $row_conf['data_agendada_agendamento']."<br>";
			echo $row_conf['hora_agendada_agendamento']."<br>";
			echo "---------------------------------------";
		
		}
		}else{
			$confirmacao_t_tentativa = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade_confirmacao' AND fbc_3 = '0' AND fbc_3 <> '2' ";
			$confirmacao_t_tentativa_query = mysqli_query($conn, $confirmacao_t_tentativa);
			$qtd_confirmacao_t_tentativa = mysqli_num_rows($confirmacao_t_tentativa_query);
			if($qtd_confirmacao_t_tentativa > 0){
				while($row_conf = mysqli_fetch_assoc($confirmacao_t_tentativa_query)){
		
			echo $row_conf['id_agendamentos']."<br>";
			echo $row_conf['id_cliente']."<br>";
			echo $row_conf['data_agendada_agendamento']."<br>";
			echo $row_conf['hora_agendada_agendamento']."<br>";
			echo "---------------------------------------";
		
				}
			}else{
				$confirmacao_q_tentativa = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade_confirmacao' AND fbc_4 = '0' AND fbc_4 <> '2' ";
				$confirmacao_q_tentativa_query = mysqli_query($conn, $confirmacao_q_tentativa);
				$qtd_confirmacao_q_tentativa = mysqli_num_rows($confirmacao_q_tentativa_query);
				if($qtd_confirmacao_q_tentativa > 0){
						while($row_conf = mysqli_fetch_assoc($confirmacao_q_tentativa_query)){		
							echo $row_conf['id_agendamentos']."<br>";
							echo $row_conf['id_cliente']."<br>";
							echo $row_conf['data_agendada_agendamento']."<br>";
							echo $row_conf['hora_agendada_agendamento']."<br>";
							echo "---------------------------------------";
		
					}
					}else{
						echo "INFORMA QUE NAO TEM MAIS AGENDADOS";
					}

				}
			}

		}
?>