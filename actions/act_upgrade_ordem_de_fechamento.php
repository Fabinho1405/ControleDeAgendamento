<?php
session_start();
ob_start();
	$idfuncionario = $_SESSION['id_usuario'];
	include_once("../conection/conexao.php");
	$unidade  = $_SESSION['unidade'];
	$contrato = $_GET['cnt'];
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
		$valormaterial= $_POST['valor_material'];
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
		}else if(empty($valormaterial)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Valor do Material!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else{

			$update_contrato = "UPDATE clientes_concept SET nome_modelo_cc = '$nomemodelo', rg_modelo_cc = '$rgmodelo', cpf_modelo_cc = '$cpfmodelo', nome_responsavel_cc = '$responsavelmodelo', rg_responsavel_cc = '$rgresponsavel', cpf_responsavel_cc = '$cpfresponsavel', nascimento_cc = '$nascimentomodelo', idade_cc = '$idademodelo', estado_civil_cc = '$civilmodelo', endereco_cc = '$enderecomodelo', numero_cc = '$numeromodelo', complemento_cc = '$complementomodelo', bairro_cc = '$bairromodelo', CEP_cc = '$cepmodelo', telefone_residencial_cc = '$telefoneprincipalmodelo', telefone_celular_cc = '$telefonesecundariomodelo', instagram_cc = '$instamodelo', facebook_cc = '$facebookmodelo', email_cc = '$emailmodelo', nome_artistico_cc = '$nomeartistico', cor_dos_olhos_cc = '$olhosmodelo', cor_do_cabelo_cc = '$cabelomodelo', cor_da_pele_cc = '$etniamodelo', altura_cc = '$alturamodelo', peso_cc = '$pesomodelo', manequim_cc = '$manequimmodelo', sapatos_cc = '$sapatomodelo', valor_material_cc = '$valormaterial', pre_venda = '0' WHERE contrato_cc = '$contrato'";
			$exec_update = mysqli_query($conn, $update_contrato);
			header("Location:../inserir_pag_form.php?ctn=$contrato");			
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
		}else if(empty($valormaterial)){
			$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Valor do Material!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
		}else{
			$update_contrato = "UPDATE clientes_exclusive SET nome_modelo_cc = '$nomemodelo', rg_modelo_cc = '$rgmodelo', cpf_modelo_cc = '$cpfmodelo', nome_responsavel_cc = '$responsavelmodelo', rg_responsavel_cc = '$rgresponsavel', cpf_responsavel_cc = '$cpfresponsavel', nascimento_cc = '$nascimentomodelo', idade_cc = '$idademodelo', estado_civil_cc = '$civilmodelo', endereco_cc = '$enderecomodelo', numero_cc = '$numeromodelo', complemento_cc = '$complementomodelo', bairro_cc = '$bairromodelo', CEP_cc = '$cepmodelo', telefone_residencial_cc = '$telefoneprincipalmodelo', telefone_celular_cc = '$telefonesecundariomodelo', instagram_cc = '$instamodelo', facebook_cc = '$facebookmodelo', email_cc = '$emailmodelo', nome_artistico_cc = '$nomeartistico', cor_dos_olhos_cc = '$olhosmodelo', cor_do_cabelo_cc = '$cabelomodelo', cor_da_pele_cc = '$etniamodelo', altura_cc = '$alturamodelo', peso_cc = '$pesomodelo', manequim_cc = '$manequimmodelo', sapatos_cc = '$sapatomodelo', valor_material_cc = '$valormaterial', pre_venda = '0' WHERE contrato_cc = '$contrato'";
			$exec_update = mysqli_query($conn, $update_contrato);
			header("Location:../inserir_pag_form.php?ctn=$contrato");
		}


	}


?>