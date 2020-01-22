<?php
	session_start(); 
	ob_start();

	include_once("../conection/conexao.php");
	$nprocedimento = $_GET['pcdm'];
	$idprocedimento = $_GET['idpcdm'];
	$decisao = $_GET['fin'];
	$produtor = $_SESSION['id_usuario']; 
	$unidade = $_SESSION['unidade'];

	if($nprocedimento == 1){
		if($unidade == 4){
			//INICIA O PROCEDIMENTO NA CONCEPT			
			$inicia_tempo_procedimento = "UPDATE acompanhamento_concept SET recepcao = '0', inicio_atendimento = NOW(), andamento_atendimento = '1', produtor_atendimento = '$produtor' WHERE id_acompanhamento = '$idprocedimento'";
			$exec_inicia_tempo_procedimento = mysqli_query($conn, $inicia_tempo_procedimento);
			header("Location: ../processo_procedimento.php");
		}else if($unidade == 1){
			//INICIA O PROCEDIMENTO NA EXCLUSIVE
			$inicia_tempo_procedimento = "UPDATE acompanhamento_exclusive SET recepcao = '0', inicio_atendimento = NOW(), andamento_atendimento = '1', produtor_atendimento = '$produtor' WHERE id_acompanhamento = '$idprocedimento'";
			$exec_inicia_tempo_procedimento = mysqli_query($conn, $inicia_tempo_procedimento);
			header("Location: ../processo_procedimento.php");
		}else{
			header("Location: ../processo_procedimento.php");
		}
	}else if($nprocedimento == 2){
		if($unidade == 4){
			if($decisao == 1){
				//ENCAMINHA PARA A RECEPCIONISTA PARA FINALIZAR O CONTRATO
				$update_encaminha_contrato = "UPDATE acompanhamento_concept SET final_atendimento = NOW(), andamento_atendimento = '0', fechamento = '1', finaliza_cliente = '1' WHERE id_acompanhamento = $idprocedimento";
				$exec_encaminha_contrato = mysqli_query($conn, $update_encaminha_contrato);
				header("Location:../pegar_procedimento.php");
			}else if($decisao == 0){
				//ENCAMINHA PARA O MOTIVO DE NÃO TER FECHADO
				header("Location:../motivo_despensa.php?idpcdm=$idprocedimento&teste=0");
			}else if($decisao == 2){ 
				$update_encaminha_contrato = "UPDATE acompanhamento_concept SET final_resultado = NOW(), andamento_resultado = '0', fechamento = '1', finaliza_cliente = '1' WHERE id_acompanhamento = $idprocedimento";
				$exec_encaminha_contrato = mysqli_query($conn, $update_encaminha_contrato);
				header("Location:../pegar_resultado.php");
			}else if($decisao == 3){
				//ENCAMINHA PARA O MOTIVO DE NÃO TER FECHADO
				header("Location:../motivo_despensa.php?idpcdm=$idprocedimento&teste=1");
			}
		}else if($unidade == 1){
			if($decisao == 1){
				//ENCAMINHA PARA A RECEPCIONISTA PARA FINALIZAR O CONTRATO
				$update_encaminha_contrato = "UPDATE acompanhamento_exclusive SET final_atendimento = NOW(), andamento_atendimento = '0', fechamento = '1', finaliza_cliente = '1' WHERE id_acompanhamento = $idprocedimento";
				$exec_encaminha_contrato = mysqli_query($conn, $update_encaminha_contrato);
				header("Location:../pegar_procedimento.php");
			}else if($decisao == 0){
				//ENCAMINHA PARA O MOTIVO DE NÃO TER FECHADO
				header("Location:../motivo_despensa.php?idpcdm=$idprocedimento&teste=0");
			}else if($decisao == 2){
				//ENCAMINHA PARA A PRÉ-VENDA

				$pesquisa_pcdm = "SELECT * FROM acompanhamento_exclusive ac  
				INNER JOIN cliente cli ON ac.id_cliente = cli.id_cliente
				WHERE ac.id_acompanhamento = '$idprocedimento'";
				$exec_pesquisa_pcdm = mysqli_query($conn, $pesquisa_pcdm);

				$row_processo = mysqli_fetch_assoc($exec_pesquisa_pcdm);

				//FINALIZA O PROCEDIMENTO COM O PRODUTOR
				$finaliza_atendimento = "UPDATE acompanhamento_exclusive SET final_resultado = NOW(), andamento_resultado = '0', fechamento = '1', finaliza_cliente = '1' WHERE id_acompanhamento = $idprocedimento";
				$exec_finaliza_atendimento = mysqli_query($conn, $finaliza_atendimento);

				//INSERE A PRÉ VENDA
				$modelo = $row_processo['nome_cliente'];
				$responsavel = $row_processo['nome_responsavel_cliente'];
				$telefone_residencial = $row_processo['telefone_cliente'];
				$celular =  $row_processo['telefone2_cliente'];
				$material = $_POST['material_modelo'];

				$insert_pre_contrato = "INSERT INTO clientes_exclusive (id_procedimento, nome_modelo_cc, nome_responsavel_cc, telefone_residencial_cc, telefone_celular_cc, material_cc, id_produtor, pre_venda, data_cadastro_cc) VALUES('$idprocedimento', $modelo', '$responsavel', '$telefone_residencial', '$celular', '$material', 'produtor', '1', NOW())";
				$exec_pre_venda = mysqli_query($conn, $insert_pre_contrato);

				header("Location: ../ultimos_contratos.php");
			}else if($decisao == 3){
				//ENCAMINHA PARA O MOTIVO DE NÃO TER FECHADO
				header("Location:../motivo_despensa.php?idpcdm=$idprocedimento&teste=1");
			}
		}
	}else if($nprocedimento == 3){
		if($unidade == 4){
			//Envia Cliente para o Teste após produção
			$update_envia_teste = "UPDATE acompanhamento_concept SET final_prod = NOW(), andamento_prod = '0', encaminhou_teste = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_envia_teste = mysqli_query($conn, $update_envia_teste);
			header("Location: ../pegar_procedimento_producao.php");

		}else if($unidade == 1){
			//Envia Cliente para o Teste
			$update_envia_teste = "UPDATE acompanhamento_exclusive SET final_prod = NOW(), andamento_prod = '0', encaminhou_teste = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_envia_teste = mysqli_query($conn, $update_envia_teste);
			header("Location: ../pegar_procedimento_producao.php");
		}

	}else if($nprocedimento == 4){
		if($unidade == 4){
			//inicia atendimento do teste
			$update_inicio_atendimento = "UPDATE acompanhamento_concept SET encaminhou_teste = '0', inicio_teste = NOW(), teste_andamento = '1', func_atendimento_teste = '$produtor' WHERE id_acompanhamento = $idprocedimento";
			$exec_inicio_atendimento = mysqli_query($conn, $update_inicio_atendimento);
			header("Location:../processo_teste_estudio.php");

		}else if($unidade == 1){
			//inicia atendimento do teste
			$update_inicio_atendimento = "UPDATE acompanhamento_exclusive SET encaminhou_teste = '0', inicio_teste = NOW(), teste_andamento = '1', func_atendimento_teste = '$produtor' WHERE id_acompanhamento = $idprocedimento";
			$exec_inicio_atendimento = mysqli_query($conn, $update_inicio_atendimento);
			header("Location:../processo_teste_estudio.php");
		}
	}else if($nprocedimento == 5){
		if($unidade == 4){
			//finaliza o teste e encaminha para resultado
			$update_final_teste = "UPDATE acompanhamento_concept SET teste_andamento = '0', final_teste = NOW(), teste_liberado = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_final_teste = mysqli_query($conn, $update_final_teste);
			header("Location: ../pegar_teste_estudio.php");

		}else if($unidade == 1){
			//finaliza o teste e encaminha para resultado
			$update_final_teste = "UPDATE acompanhamento_exclusive SET teste_andamento = '0', final_teste = NOW(), teste_liberado = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_final_teste = mysqli_query($conn, $update_final_teste);
			header("Location: ../pegar_teste_estudio.php");
		}
	}else if($nprocedimento == 6){
		if($unidade == 4){
			$update_inicio_resultado = "UPDATE acompanhamento_concept SET teste_liberado = '0', inicio_resultado = NOW(), andamento_resultado = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_inicio_resultado = mysqli_query($conn, $update_inicio_resultado);
			header("Location:../processo_resultado.php");

		}else if($unidade == 1){
			//inicia atendimento do resultado
			$update_inicio_resultado = "UPDATE acompanhamento_exclusive SET teste_liberado = '0', inicio_resultado = NOW(), andamento_resultado = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_inicio_resultado = mysqli_query($conn, $update_inicio_resultado);
			header("Location:../processo_resultado.php");
		}
	}else if($nprocedimento == 7){
		//ENVIA PARA PRODUÇÃO PARA TESTE
		if($unidade == 4){
			//ESSA UNIDADE NAO POSSUI PRODUÇÃO EM TESTE
			echo "ESSA UNIDADE NÃO POSSUI PRODUÇÃO EM TESTE";
		}else if($unidade == 1){
			$update_envia_teste = "UPDATE acompanhamento_exclusive SET final_atendimento = NOW(), andamento_atendimento = '0', encaminhou_prod = '1' WHERE id_acompanhamento = $idprocedimento";
			$exec_envia_teste = mysqli_query($conn, $update_envia_teste);
			header("Location: ../pegar_procedimento.php");
		}
	}else if($nprocedimento == 8){
		if($unidade == 4){

		}else if($unidade == 1){
			$update_inicio_atendimento = "UPDATE acompanhamento_exclusive SET encaminhou_prod = '0', inicio_prod = NOW(), andamento_prod = '1', func_atendimento_prod = '$produtor' WHERE id_acompanhamento = $idprocedimento";
			$exec_inicio_atendimento = mysqli_query($conn, $update_inicio_atendimento);
			header("Location:../processo_teste_producao.php");
		}
	}


?>