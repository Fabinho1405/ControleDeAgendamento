<?php
	session_start();
	ob_start();
	$idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];

	include_once("../conection/conexao.php");
	$metodo = $_GET['metodo'];
	$ncontrato = $_GET['ctn'];
	$valor_dinheiro = $_POST['valor_dinheiro'];
	$funcionario = $_SESSION['id_usuario'];
	$valor_cheque = $_POST['valor_cheque'];
	$data_agrado_cheque = $_POST['data_agrado_cheque'];

	$valortotalB = $_POST['valor_boleto'];
	$data_att = $_POST['data_agrado_boleto'];
	$nparcela = $_POST['qtd_boleto'];

	$valor_debito = $_POST['valor_debito'];
	$valor_credito = $_POST['valor_credito'];
	$valor_deposito = $_POST['valor_deposito'];
	$data_agrado_deposito = $_POST['data_agrado_deposito'];
	$valor_via_unica = $_POST['valor_via_unica'];
	$data_agrado_via_unica = $_POST['data_agrado_via_unica'];

	//VERIFICA O VALOR SE ESTÁ DISPONÍVEL PARA INSERIR OU SE ULTRAPASSA O VALOR TOTAL
	if($unidadefunc == 4){
		$select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$ncontrato'";
	    $exec_select_contrato = mysqli_query($conn, $select_contrato);
	    $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

	    $valor_total_contrato = $row_contrato['valor_material_cc'];
	    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_concept WHERE n_contrato_lancamento = '$ncontrato' AND status_lancamento <> 3 AND status = '1'";
	    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
	    $final_aberto = 0;
	    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
	        $valor_atual = $row_pagamento['valor_lancamento'];
	        $final_aberto = $final_aberto + $valor_atual;
	    }
	}else if($unidadefunc == 1){
		$select_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$ncontrato'";
	    $exec_select_contrato = mysqli_query($conn, $select_contrato);
	    $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

	    $valor_total_contrato = $row_contrato['valor_material_cc'];
	    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_exclusive WHERE n_contrato_lancamento = '$ncontrato' AND status_lancamento <> 3 AND status = '1'";
	    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
	    $final_aberto = 0;
	    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
	        $valor_atual = $row_pagamento['valor_lancamento'];
	        $final_aberto = $final_aberto + $valor_atual;
	    }
	};
    $final_aberto_pag = $valor_total_contrato - $final_aberto;


	if($metodo == 1){
		//REGISTRA PAGAMENTO EM DINHEIRO
		if($valor_dinheiro <= $final_aberto_pag){
			if($unidadefunc == 4){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, created_lancamento, data_baixa_lancamento) VALUES (1, '$valor_dinheiro', 2, $funcionario, '$ncontrato', NOW(), NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Dinheiro, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			}else if($unidadefunc == 1){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, created_lancamento, data_baixa_lancamento) VALUES (1, '$valor_dinheiro', 2, $funcionario, '$ncontrato', NOW(), NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Dinheiro, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			};
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}
	}else if($metodo == 2){
		//REGISTRA PAGAMENTO EM CHEQUE
		if($valor_cheque <= $final_aberto_pag){
			if($unidadefunc == 4){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (2, '$valor_cheque', 1, $funcionario, '$ncontrato','$data_agrado_cheque',NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Cheque, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			}else if($unidadefunc == 1){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (2, '$valor_cheque', 1, $funcionario, '$ncontrato','$data_agrado_cheque',NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Cheque, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			};
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}
	}else if($metodo == 3){
		//REGISTRA PAGAMENTO EM BOLETO
		if($valortotalB <= $final_aberto_pag){
			//LOGICA BOLTO INICIO
				$array_parcelas =  array($nparcela);
				$array_datas = array($nparcela);				
				$i = 1;	
				$valor_parcela = round($valortotalB / $nparcela, 2);
				while($i <= $nparcela){
					$array_parcelas[$i] = $valor_parcela;
					$data_att = date('Y-m-d', strtotime("+1 month", strtotime($data_att)));
					$array_datas[$i] = $data_att;
					$i++;
				};
				$total_conf = 0;
				$j = 1;
				while($j <= $nparcela){
					$total_conf = $total_conf + $array_parcelas[$j];
					$j++;
				};
				$faltante = $valortotalB - $total_conf;
				$array_parcelas[1] = $array_parcelas[1] + $faltante;
				$k = 2;
				$parcela1valor = $array_parcelas[1];
				$parcela1data = $array_datas[1];
				if($unidadefunc == 4){
					$insert_parcela = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (3, '$parcela1valor', 1, $funcionario, '$ncontrato','$parcela1data',NOW())";
					$exec_insert_parcela = mysqli_query($conn, $insert_parcela);
				}else if($unidadefunc == 1){
					$insert_parcela = "INSERT INTO lancamento_exclusive(tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (3, '$parcela1valor', 1, $funcionario, '$ncontrato','$parcela1data',NOW())";
					$exec_insert_parcela = mysqli_query($conn, $insert_parcela);
				};
				while($k <= $nparcela){
					$parcelavalor = $array_parcelas[$k];
					$parceladata = $array_datas[$k];
					if($unidadefunc == 4){
						$insert_parcela_resto = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (3, '$parcelavalor', 1, $funcionario, '$ncontrato','$parceladata',NOW())";
						$exec_parcela_resto = mysqli_query($conn, $insert_parcela_resto);
					}else if($unidadefunc == 1){
						$insert_parcela_resto = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (3, '$parcelavalor', 1, $funcionario, '$ncontrato','$parceladata',NOW())";
						$exec_parcela_resto = mysqli_query($conn, $insert_parcela_resto);
					}
					$k++;
				}
			//LOGICA BOLETO FIM
			$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
	                                          <center> Lançamento em Boleto, Efetuado! </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		};

	}else if($metodo == 4){
		//REGISTRA PAGAMENTO EM CARTÃO DE DÉBITO
		if($valor_debito <= $final_aberto_pag){
			if($unidadefunc == 4){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, created_lancamento, data_baixa_lancamento) VALUES (4, '$valor_debito', 2, $funcionario, '$ncontrato', NOW(), NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Débito, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			}else if($unidadefunc == 1){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, created_lancamento, data_baixa_lancamento) VALUES (4, '$valor_debito', 2, $funcionario, '$ncontrato', NOW(), NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Débito, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			};
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}
	}else if($metodo == 5){
		//REGISTRA PAGAMENTO EM CARTÃO DE CRÉDITO
		if($valor_credito <= $final_aberto_pag){
			if($unidadefunc == 4){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, created_lancamento, data_baixa_lancamento) VALUES (5, '$valor_credito', 2, $funcionario, '$ncontrato', NOW(), NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Crédito, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			}else if($unidadefunc == 1){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, created_lancamento, data_baixa_lancamento) VALUES (5, '$valor_credito', 2, $funcionario, '$ncontrato', NOW(), NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Crédito, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			};
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}

	}else if($metodo == 6){
		//REGISTRA PAGAMENTO EM DEPÓSITO BANCÁRIO
		if($valor_deposito <= $final_aberto_pag){
			if($unidadefunc == 4){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (6, '$valor_deposito', 1, $funcionario, '$ncontrato','$data_agrado_deposito',NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Depósito Bancário, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			}else if($unidadefunc == 1){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (6, '$valor_deposito', 1, $funcionario, '$ncontrato','$data_agrado_deposito',NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Depósito Bancário, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			};
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}

	}else if($metodo == 7){
		//REGISTRA VIA UNICA
		if($valor_via_unica <= $final_aberto_pag){
			if($unidadefunc == 4){
			$insere_pagamento_dinheiro = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (7, '$valor_via_unica', 1, $funcionario, '$ncontrato','$data_agrado_via_unica',NOW())";
			$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
			$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
	                                          <center> Lançamento em Via Única, Efetuado! </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			}else if($unidadefunc == 1){
				$insere_pagamento_dinheiro = "INSERT INTO lancamento_exclusive (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (7, '$valor_via_unica', 1, $funcionario, '$ncontrato','$data_agrado_via_unica',NOW())";
				$exec_insere_pagamento = mysqli_query($conn, $insere_pagamento_dinheiro);
				$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
		                                          <center> Lançamento em Via Única, Efetuado! </center></div>";
				header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
			};
		}else{
			$_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                          <center> O valor inserido, <b>excede</b> o valor total do produto. </center></div>";
			header("Location: ../inserir_pag_form.php?ctn=$ncontrato");
		}
	}




?>