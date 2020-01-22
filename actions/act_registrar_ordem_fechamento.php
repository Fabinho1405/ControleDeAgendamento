<?php
	session_start();
	ob_start();
	$idfuncionario = $_SESSION['id_usuario'];
	include_once("../conection/conexao.php");
	$unidade  = $_SESSION['unidade'];
	//Variavéis do formulário de ambas unidades
	//Ordem de Fechamento Concept
		$nomemodelo = $_POST['nome_modelo'];
		$rgmodelo = $_POST['rg_modelo'];
		$cpfmodelo = $_POST['cpf_modelo'];
		$responsavelmodelo = $_POST['responsavel_modelo'];
		$rgresponsavel = $_POST['rg_responsavel'];
		$cpfresponsavel = $_POST['cpf_responsavel'];
		$nascimentomodelo = $_POST['nascimento_modelo'];
		$idademodelo = $_POST['idade_modelo'];
		$civilmodelo = $_POST['civil_modelo'];
		$cepmodelo = $_POST['cep_modelo'];
		$enderecomodelo = $_POST['endereco_modelo'];
		$numeromodelo = $_POST['numero_modelo'];
		$complementomodelo = $_POST['complemento_modelo'];
		$bairromodelo = $_POST['bairro_modelo'];
		$telefoneprincipalmodelo = $_POST['telefoneprincipal_modelo'];
		$telefonesecundariomodelo = $_POST['telefonesecundario_modelo'];
		$instamodelo = $_POST['instagram_modelo'];
		$facebookmodelo = $_POST['facebook_modelo'];
		$emailmodelo = $_POST['email_modelo'];
		$nomeartistico = $_POST['nome_artistico_modelo'];
		$alturamodelo = $_POST['altura_modelo'];
		$pesomodelo = $_POST['peso_modelo'];
		$manequimmodelo = $_POST['manequim_modelo'];
		$sapatomodelo = $_POST['sapato_modelo'];
		$olhosmodelo = $_POST['olhos_modelo'];
		$cabelomodelo = $_POST['cabelo_modelo'];
		$etniamodelo = $_POST['etnia_modelo'];
		$materialmodelo = $_POST['material_modelo'];
		$valormaterial= $_POST['valor_material'];
		$produtor = $_POST['select_produtor'];
		$encaminhamento = $_POST['encaminhamento_modelo'];

	if($unidade == 4){
		//Verficia se o Nome do Modelo foi Completo
		if(empty($nomemodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Nome do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($rgmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o RG do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($cpfmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o CPF do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($idademodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Idade do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($cepmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o CEP!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($enderecomodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Endereço!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($numeromodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Número da Residência!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($bairromodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Bairro do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($telefoneprincipalmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Telefone Principal do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($alturamodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Altura do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($pesomodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Peso do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($manequimmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Manequim do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($materialmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Material do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($valormaterial)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Valor do Material!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($produtor)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Produtor!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else{
			//CONFERE SE O CONTRATO JA EXISTE
			$select_contrato = "SELECT * FROM clientes_concept WHERE cpf_modelo_cc = '$cpfmodelo'";
			$exec_select_contrato = mysqli_query($conn, $select_contrato);
			$qtd_contrato = mysqli_num_rows($qtd_contrato);
			if($qtd_contrato == 0){
			$insert_ordem = "INSERT INTO clientes_concept(nome_modelo_cc, rg_modelo_cc, cpf_modelo_cc, nome_responsavel_cc, rg_responsavel_cc, cpf_responsavel_cc, nascimento_cc, idade_cc, estado_civil_cc, CEP_cc, endereco_cc,numero_cc, complemento_cc, bairro_cc, telefone_residencial_cc, telefone_celular_cc, `instagram_cc`, `facebook_cc`, `email_cc`, nome_artistico_cc, altura_cc, peso_cc, manequim_cc, sapatos_cc, cor_dos_olhos_cc, cor_do_cabelo_cc, cor_da_pele_cc, material_cc, valor_material_cc, id_produtor, data_cadastro_cc) VALUES ('$nomemodelo', '$rgmodelo', '$cpfmodelo', '$responsavelmodelo', '$rgresponsavel', '$cpfresponsavel', '$nascimentomodelo', '$idademodelo', '$civilmodelo', '$cepmodelo', '$enderecomodelo','$numeromodelo', '$complementomodelo', '$bairromodelo', '$telefoneprincipalmodelo', '$telefonesecundariomodelo', '$instamodelo', '$facebookmodelo', '$emailmodelo', '$nomeartistico', '$alturamodelo', '$pesomodelo', '$manequimmodelo', '$sapatomodelo', '$olhosmodelo', '$cabelomodelo', '$etniamodelo', '$materialmodelo', '$valormaterial', '$produtor', NOW())";
			$exec_insert_ordem = mysqli_query($conn, $insert_ordem);

			$procurar_contrato_cliente = "SELECT contrato_cc FROM clientes_concept WHERE rg_modelo_cc = '$rgmodelo' OR cpf_modelo_cc = '$cpfmodelo' AND nome_modelo_cc = '$nomemodelo' LIMIT 1";
			$exec_procurar_contrato_cliente = mysqli_query($conn, $procurar_contrato_cliente);
			$row_contrato = mysqli_fetch_assoc($exec_procurar_contrato_cliente);
			$novocontrato = $row_contrato['contrato_cc'];

			if($encaminhamento == 1){
				//Encaminha modelo para o estúdio.
				header("Location:../encaminhar_estudio.php?nc=$novocontrato");
			}else if($encaminhamento == 2){
				//Encaminha modelo para agendar retorno.
				header("Location:../agendar_retorno.php?nc=$novocontrato");
			}else if($encaminhamento == 3){
				//encaminha para forma de pagamento
				header("Location:../inserir_pag_form.php?ctn=$novocontrato");
			}
		}
		}
	}else if($unidade == 1){
		//Verficia se o Nome do Modelo foi Completo
		if(empty($nomemodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Nome do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($rgmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o RG do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($cpfmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o CPF do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($idademodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Idade do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($cepmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o CEP!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($enderecomodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Endereço!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($numeromodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Número da Residência!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($bairromodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Bairro do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($telefoneprincipalmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Telefone Principal do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($alturamodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Altura do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($pesomodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Peso do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($manequimmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Manequim do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($materialmodelo)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Material do Modelo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($valormaterial)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Valor do Material!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else if(empty($produtor)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Produtor!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else{
			$insert_ordem = "INSERT INTO clientes_exclusive(nome_modelo_cc, rg_modelo_cc, cpf_modelo_cc, nome_responsavel_cc, rg_responsavel_cc, cpf_responsavel_cc, nascimento_cc, idade_cc, estado_civil_cc, CEP_cc, endereco_cc,numero_cc, complemento_cc, bairro_cc, telefone_residencial_cc, telefone_celular_cc, `instagram_cc`, `facebook_cc`, `email_cc`, nome_artistico_cc, altura_cc, peso_cc, manequim_cc, sapatos_cc, cor_dos_olhos_cc, cor_do_cabelo_cc, cor_da_pele_cc, material_cc, valor_material_cc, id_produtor, data_cadastro_cc) VALUES ('$nomemodelo', '$rgmodelo', '$cpfmodelo', '$responsavelmodelo', '$rgresponsavel', '$cpfresponsavel', '$nascimentomodelo', '$idademodelo', '$civilmodelo', '$cepmodelo', '$enderecomodelo','$numeromodelo', '$complementomodelo', '$bairromodelo', '$telefoneprincipalmodelo', '$telefonesecundariomodelo', '$instamodelo', '$facebookmodelo', '$emailmodelo', '$nomeartistico', '$alturamodelo', '$pesomodelo', '$manequimmodelo', '$sapatomodelo', '$olhosmodelo', '$cabelomodelo', '$etniamodelo', '$materialmodelo', '$valormaterial', '$produtor', NOW())";
			$exec_insert_ordem = mysqli_query($conn, $insert_ordem);

			$procurar_contrato_cliente = "SELECT contrato_cc FROM clientes_exclusive WHERE rg_modelo_cc = '$rgmodelo' OR cpf_modelo_cc = '$cpfmodelo' AND nome_modelo_cc = '$nomemodelo' LIMIT 1";
			$exec_procurar_contrato_cliente = mysqli_query($conn, $procurar_contrato_cliente);
			$row_contrato = mysqli_fetch_assoc($exec_procurar_contrato_cliente);
			$novocontrato = $row_contrato['contrato_cc'];

			if($encaminhamento == 1){
				//Encaminha modelo para o estúdio.
				header("Location:../encaminhar_estudio.php?nc=$novocontrato");
			}else if($encaminhamento == 2){
				//Encaminha modelo para agendar retorno.
				header("Location:../agendar_retorno.php?nc=$novocontrato");
			}else if($encaminhamento == 3){
				//encaminha para forma de pagamento
				header("Location:../inserir_pag_form.php?ctn=$novocontrato");
			}
		}


	}


?>