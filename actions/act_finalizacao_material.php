<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$contrato = $_GET['cnt'];
	$procedimento = $_GET['pcdm'];
	$idfuncionario = $_SESSION['id_usuario'];
	$unidadefunc = $_SESSION['unidade'];

	if($unidadefunc == 1){
		$pesquisa_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_CC = '$contrato' LIMIT 1";
		$exec_pesquisa_contrato = mysqli_query($conn, $pesquisa_contrato);
		$qtd_contrato = mysqli_num_rows($exec_pesquisa_contrato);

		if($qtd_contrato = 1){
			//ENCONTROU CONTRATO PEGA INFORMAÇÕES DELE
			$row_contrato = mysqli_fetch_assoc($exec_pesquisa_contrato);
			$valor_material = $row_contrato['valor_material_cc'];

			//VERIFICA SE O CONTRATO JÁ FOI ENVIADO PARA ANÁLISE
			$enviadoAnalise="SELECT * FROM clientes_exclusive WHERE data_enviado_analise <> '' AND contrato_cc='$contrato'";
			$execEnviadoAnalise=mysqli_query($conn, $enviadoAnalise);
			$qtdEnviado=mysqli_num_rows($execEnviadoAnalise);

			if($qtdEnviado == 1){
				//INFORMA QUE O MATERIAL JÁ FOI ENVIADO PARA ANÁLISE 
				$_SESSION['aut_contrato']=6;
				$_SESSION['n_contrato']=$contrato;
				$_SESSION['pcdm']=$procedimento;
				header("Location:../finalizacao_material.php"); 
			}else{
			//PESQUISA SE HÁ LANÇAMENTO DE VALOR NESSE CONTRATO
			$select_lancamento = "SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento = '$contrato' AND status_lancamento <> 3 AND status = '1'";
			$exec_select_lancamento = mysqli_query($conn, $select_lancamento);
			$qtd_lancamento = mysqli_num_rows($exec_select_lancamento);
			if($qtd_lancamento >= 1){
				//VERIFICA SE A QUANTIDADE PAGA ABATE COM O VALOR TOTAL DO MATERIAL
				$valor_lancado = 0;
				while($row_lancamento = mysqli_fetch_assoc($exec_select_lancamento)){
					//SOMA TODOS OS VALORES QUE FORAM LANÇADOS
					$valor_lancado = $valor_lancado + $row_lancamento['valor_lancamento']; 
				}
				//VERIFICA SE OS VALORES BATEM
				$valor_faltante = $valor_material - $valor_lancado;
				if($valor_faltante < 1){
					//VERIFICA AGORA O VALOR QUE FOI PAGO PELO CLIENTE
					$select_valor_pago = "SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento = '$contrato' AND status_lancamento = '2' AND status = '1'";
					$exec_valor_pago = mysqli_query($conn, $select_valor_pago);
					$valor_pago = 0;
					while($row_pago = mysqli_fetch_assoc($exec_valor_pago)){
						//SOMA TODOS OS VALORES QUE FORAM PAGOS
						$valor_pago = $valor_pago + $row_pago['valor_lancamento'];
					}
					//VERIFICA SE O VALOR PAGO JÁ CORRESPONDER À PELO MENOS 40% DO VALOR TOTAL DO MATERIAL
					$valorporcentagem = $valor_material * 0.4;

					if($valor_pago > $valorporcentagem){
						//AUTORIZA O MATERIAL PARA EDIÇÃO POIS CONSTROU + 40% PAGO
						//NAO ESQUECER DE FINALIZAR O PROCEDIMENTO $_GET['PCDM']
						$_SESSION['aut_contrato'] = 1;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
					}else{
						//MATERIAL FICA PARADO NA FILA DA GERÊNCIA, POIS NÃO CONSTA PELO MENOS 40% DO MATERIAL PAGO
						$_SESSION['aut_contrato'] = 5;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
					}
				}else{
					//VALORES DE LANÇAMENTO DIVERGENTES, OU SEJA, FALTA LANÇAR ALGO EM LANÇAMENTO PARA FECHAR O VALOR DO CONTRATO
						$_SESSION['aut_contrato'] = 3;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
				}
			}else{
				//NÃO HÁ NENHUM LANÇAMENTO NESSE CONTRATO
						$_SESSION['aut_contrato'] = 4;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
			}
		}
		}else{
			//NÃO ENCONTROU NENHUM CONTRATO
						$_SESSION['aut_contrato'] = 0;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
		}



	}else if($unidadefunc == 4){
		$pesquisa_contrato = "SELECT * FROM clientes_concept WHERE contrato_CC = '$contrato' LIMIT 1";
		$exec_pesquisa_contrato = mysqli_query($conn, $pesquisa_contrato);
		$qtd_contrato = mysqli_num_rows($exec_pesquisa_contrato);

		if($qtd_contrato = 1){
			//ENCONTROU CONTRATO PEGA INFORMAÇÕES DELE
			$row_contrato = mysqli_fetch_assoc($exec_pesquisa_contrato);
			$valor_material = $row_contrato['valor_material_cc'];

			//VERIFICA SE O CONTRATO JÁ FOI ENVIADO PARA ANÁLISE
			$enviadoAnalise="SELECT * FROM clientes_concept WHERE data_enviado_analise <> '' AND contrato_cc='$contrato'";
			$execEnviadoAnalise=mysqli_query($conn, $enviadoAnalise);
			$qtdEnviado=mysqli_num_rows($execEnviadoAnalise);

			if($qtdEnviado == 1){
				//INFORMA QUE O MATERIAL JÁ FOI ENVIADO PARA ANÁLISE 
				$_SESSION['aut_contrato']=6;
				$_SESSION['n_contrato']=$contrato;
				$_SESSION['pcdm']=$procedimento;
				header("Location:../finalizacao_material.php"); 
			}else{
			//PESQUISA SE HÁ LANÇAMENTO DE VALOR NESSE CONTRATO
			$select_lancamento = "SELECT * FROM lancamento_concept WHERE n_contrato_lancamento = '$contrato' AND status_lancamento <> 3 AND status = '1'";
			$exec_select_lancamento = mysqli_query($conn, $select_lancamento);
			$qtd_lancamento = mysqli_num_rows($exec_select_lancamento);
			if($qtd_lancamento >= 1){
				//VERIFICA SE A QUANTIDADE PAGA ABATE COM O VALOR TOTAL DO MATERIAL
				$valor_lancado = 0;
				while($row_lancamento = mysqli_fetch_assoc($exec_select_lancamento)){
					//SOMA TODOS OS VALORES QUE FORAM LANÇADOS
					$valor_lancado = $valor_lancado + $row_lancamento['valor_lancamento']; 
				}
				//VERIFICA SE OS VALORES BATEM
				$valor_faltante = $valor_material - $valor_lancado;
				if($valor_faltante < 1){
					//VERIFICA AGORA O VALOR QUE FOI PAGO PELO CLIENTE
					$select_valor_pago = "SELECT * FROM lancamento_concept WHERE n_contrato_lancamento = '$contrato' AND status_lancamento = '2' AND status = '1'";
					$exec_valor_pago = mysqli_query($conn, $select_valor_pago);
					$valor_pago = 0;
					while($row_pago = mysqli_fetch_assoc($exec_valor_pago)){
						//SOMA TODOS OS VALORES QUE FORAM PAGOS
						$valor_pago = $valor_pago + $row_pago['valor_lancamento'];
					}
					//VERIFICA SE O VALOR PAGO JÁ CORRESPONDER À PELO MENOS 40% DO VALOR TOTAL DO MATERIAL
					$valorporcentagem = $valor_material * 0.4;

					if($valor_pago > $valorporcentagem){
						//AUTORIZA O MATERIAL PARA EDIÇÃO POIS CONSTROU + 40% PAGO
						//NAO ESQUECER DE FINALIZAR O PROCEDIMENTO $_GET['PCDM']
						$_SESSION['aut_contrato'] = 1;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
					}else{
						//MATERIAL FICA PARADO NA FILA DA GERÊNCIA, POIS NÃO CONSTA PELO MENOS 40% DO MATERIAL PAGO
						$_SESSION['aut_contrato'] = 5;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
					}
				}else{
					//VALORES DE LANÇAMENTO DIVERGENTES, OU SEJA, FALTA LANÇAR ALGO EM LANÇAMENTO PARA FECHAR O VALOR DO CONTRATO
						$_SESSION['aut_contrato'] = 3;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
				}
			}else{
				//NÃO HÁ NENHUM LANÇAMENTO NESSE CONTRATO
						$_SESSION['aut_contrato'] = 4;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
			}
		}
		}else{
			//NÃO ENCONTROU NENHUM CONTRATO
						$_SESSION['aut_contrato'] = 0;
						$_SESSION['n_contrato'] = $contrato;
						$_SESSION['pcdm'] = $procedimento;
						header("Location:../finalizacao_material.php");
		}


	}






?>