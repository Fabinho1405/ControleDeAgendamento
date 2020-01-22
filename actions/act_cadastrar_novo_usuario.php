<?php
	include_once("../conection/conexao.php");
	ob_start();

	$nomecompleto = $_POST['nome_completo'];
	$telefone = $_POST['telefone'];
	$datanascimento = $_POST['data_nascimento'];
	$login = $_POST['login'];
	$senhacomum = $_POST['senha'];
	$permissao = $_POST['permissao'];
	$unidade = $_POST['select_unidade_func'];

	$senhacriptografada = password_hash("$senhacomum", PASSWORD_DEFAULT);
	/*
	echo $nomecompleto."<br>";
	echo $telefone."<br>";
	echo $datanascimento."<br>";
	echo $login."<br>";
	echo $senhacomum."<br>";
	echo $permissao."<br>";
	echo $senhacriptografada."<br>";
	*/
	if(!empty($permissao)){
		if($permissao == 1){
			//SCOUTER LIGAÇÃO
			$cad_novo_usuario = "INSERT INTO funcionario (CPF_func,senha_func,nome_completo_func,data_nascimento_func,telefone_func,status_sistema,permissao,menu_scouter_ligacao_new,menu_scouter_wts,menu_scouter_insta,menu_confirmacao,menu_supervisao,menu_gerencia, data_cadastro_func, id_locado, id_unidade) VALUES ('$login','$senhacriptografada','$nomecompleto','$datanascimento','$telefone','1','99','1','0','0','0','0','0', NOW(), '4', '$unidade');";
			$cadastrar_usuario = mysqli_query($conn, $cad_novo_usuario);
			$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
            header("Location:../novo_usuario.php");
			
		}else if($permissao == 2){
			//SCOUTER INSTAGRAM
			$cad_novo_usuario = "INSERT INTO funcionario (CPF_func,senha_func,nome_completo_func,data_nascimento_func,telefone_func,status_sistema,permissao,menu_scouter_ligacao,menu_scouter_wts,menu_scouter_insta,menu_confirmacao,menu_supervisao,menu_gerencia, data_cadastro_func, id_locado, id_unidade) VALUES ('$login','$senhacriptografada','$nomecompleto','$datanascimento','$telefone','1','99','0','0','1','0','0','0', NOW(), '4', '$unidade');";
			$cadastrar_usuario = mysqli_query($conn, $cad_novo_usuario);
			$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
            header("Location:../novo_usuario.php");
		}else if($permissao == 3){
			//SCOUTER WHATSAPP
			$cad_novo_usuario = "INSERT INTO funcionario (CPF_func,senha_func,nome_completo_func,data_nascimento_func,telefone_func,status_sistema,permissao,menu_scouter_ligacao,menu_scouter_wts,menu_scouter_insta,menu_confirmacao,menu_supervisao,menu_gerencia, data_cadastro_func, id_locado, id_unidade) VALUES ('$login','$senhacriptografada','$nomecompleto','$datanascimento','$telefone','1','99','0','1','0','0','0','0', NOW(), '4', '$unidade');";
			$cadastrar_usuario = mysqli_query($conn, $cad_novo_usuario);
			$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
            header("Location:../novo_usuario.php");
		}
	}else{
		$_SESSION['msg_cad'] = "<div class='alert alert-warning' role='alert'>
                                          <center> Preencha corretamente a  <b> Permissão </b>! </center>";
                                           header("Location:../novo_usuario.php");

	}




?>