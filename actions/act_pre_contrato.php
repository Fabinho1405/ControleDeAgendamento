<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idfuncionario = $_POST['select_produtor'];	
	$unidade  = $_SESSION['unidade'];
	$procedimento = $_GET['acp']; 
	$test = $_GET['test'];

	//pesquisa o procedimento
		if($unidade == 1){ 
			if($test == 0){
			$pesquisa_pcdm = "SELECT * FROM acompanhamento_exclusive ac  
			INNER JOIN cliente cli ON ac.id_cliente = cli.id_cliente
			WHERE ac.id_acompanhamento = '$procedimento'";
			$exec_pesquisa_pcdm = mysqli_query($conn, $pesquisa_pcdm);

			$row_processo = mysqli_fetch_assoc($exec_pesquisa_pcdm);

			//FINALIZA O PROCEDIMENTO COM O PRODUTOR
			$finaliza_atendimento = "UPDATE acompanhamento_exclusive SET final_atendimento = NOW(), andamento_atendimento = '0', fechamento = '1', finaliza_cliente = '1' WHERE id_acompanhamento = $procedimento";
			$exec_finaliza_atendimento = mysqli_query($conn, $finaliza_atendimento);

			//INSERE A PRÉ VENDA
			$modelo = $row_processo['nome_cliente'];
			$responsavel = $row_processo['nome_responsavel_cliente'];
			$telefone_residencial = $row_processo['telefone_cliente'];
			$celular =  $row_processo['telefone2_cliente'];
			$material = $_POST['material_modelo'];
			$idcli=$row_processo['id_cliente'];
			$idagendamento=$row_processo['id_agendamento'];

			$insert_pre_contrato = "INSERT INTO clientes_exclusive (id_procedimento,id_cliente, id_agendamento, nome_modelo_cc, nome_responsavel_cc, telefone_residencial_cc, telefone_celular_cc, material_cc, id_produtor, pre_venda, data_cadastro_cc) VALUES ('$procedimento','$idcli', '$idagendamento' ,'$modelo', '$responsavel', '$telefone_residencial', '$celular', '$material', '$idfuncionario', '1', NOW())";
			$exec_pre_venda = mysqli_query($conn, $insert_pre_contrato);

				if($_SESSION['menu_recepcao'] == 1){
					header("Location:../fila_contratos.php");
				}else{
					header("Location: ../ultimos_contratos.php");
				}	
			}else if($test == 1){
				$pesquisa_pcdm = "SELECT * FROM acompanhamento_exclusive ac  
				INNER JOIN cliente cli ON ac.id_cliente = cli.id_cliente
				WHERE ac.id_acompanhamento = '$procedimento'";
				$exec_pesquisa_pcdm = mysqli_query($conn, $pesquisa_pcdm);

				$row_processo = mysqli_fetch_assoc($exec_pesquisa_pcdm);

				//FINALIZA O PROCEDIMENTO COM O PRODUTOR
				$finaliza_atendimento = "UPDATE acompanhamento_exclusive SET final_resultado = NOW(), andamento_resultado = '0', fechamento = '1', finaliza_cliente = '1' WHERE id_acompanhamento = $procedimento";
				$exec_finaliza_atendimento = mysqli_query($conn, $finaliza_atendimento);

				//INSERE A PRÉ VENDA
				$modelo = $row_processo['nome_cliente'];
				$responsavel = $row_processo['nome_responsavel_cliente'];
				$telefone_residencial = $row_processo['telefone_cliente'];
				$celular =  $row_processo['telefone2_cliente'];
				$material = $_POST['material_modelo'];

				$insert_pre_contrato = "INSERT INTO clientes_exclusive (id_procedimento, nome_modelo_cc, nome_responsavel_cc, telefone_residencial_cc, telefone_celular_cc, material_cc, id_produtor, pre_venda, data_cadastro_cc) VALUES ('$procedimento', '$modelo', '$responsavel', '$telefone_residencial', '$celular', '$material', '$idfuncionario', '1', NOW())";
				$exec_pre_venda = mysqli_query($conn, $insert_pre_contrato);

				header("Location: ../ultimos_contratos.php");
			}
		}else if($unidade == 4){
			$pesquisa_pcdm = "SELECT * FROM acompanhamento_concept ac  
			INNER JOIN cliente cli ON ac.id_cliente = cli.id_cliente
			WHERE ac.id_acompanhamento = '$procedimento'";
			$exec_pesquisa_pcdm = mysqli_query($conn, $pesquisa_pcdm);

			$row_processo = mysqli_fetch_assoc($exec_pesquisa_pcdm);

			//INSERE A PRÉ VENDA
			$modelo = $row_processo['nome_cliente'];
			$responsavel = $row_processo['nome_responsavel_cliente'];
			$telefone_residencial = $row_processo['telefone_cliente'];
			$celular =  $row_processo['telefone2_cliente'];
			$material = $_POST['material_modelo'];

			$insert_pre_contrato = "INSERT INTO clientes_concept (nome_modelo_cc, nome_responsavel_cc, telefone_residencial_cc, telefone_celular_cc, material_cc, id_produtor, pre_venda, data_cadastro_cc) VALUES ('$modelo', '$responsavel', '$telefone_residencial', '$celular', '$material', '$idfuncionario', '1', NOW())";
			$exec_pre_venda = mysqli_query($conn, $insert_pre_contrato);

			header("Location: ../ultimos_contratos.php");
		};
		

?>