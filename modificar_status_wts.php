<?php
	
	include_once("conection/conexao.php");
	$select = $_POST['select_status'];
	$idcontrole = $_GET['idcontrole'];

	if($select == 1){
		echo "EM ABERTO AINDA";
	}else if($select == 2){
		$result_agenda = "SELECT * FROM controle_fichas WHERE id_controle = $idcontrole";
		$resultado_agenda = mysqli_query($conn, $result_agenda);
		while($row_agenda = mysqli_fetch_assoc($resultado_agenda)){
		header("Location: cadastrar_agendamento_wts.php?idcontrole=".$row_agenda['id_controle']."&nomeresponsavel=".$row_agenda['nome_responsavel_controle']."&nomemodelo=".$row_agenda['nome_modelo_controle']."&telefoneprincipal=".$row_agenda['telefone_principal_controle']."&telefonesecundario=".$row_agenda['telefone_secundario_controle']."&idfuncionario=".$row_agenda['id_func']."&extracao=".$row_agenda['id_extracao']);
		}
	}else if($select == 3 || $select == 4 || $select == 5 || $select == 6 || $select == 8 ){
		$result_agenda = "SELECT * FROM controle_fichas WHERE id_controle = $idcontrole";
		$resultado_agenda = mysqli_query($conn, $result_agenda);
		while($row_agenda = mysqli_fetch_assoc($resultado_agenda)){

		if($row_agenda['fb_7'] <> 0){		
				$insert_off = "UPDATE controle_fichas SET id_status_sistema = 0 WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_off);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_1'] == 1){
				$insert_fb1 = "UPDATE controle_fichas SET fb_1 = $select, fb_1_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb1);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_2'] == 0){
				$insert_fb2 = "UPDATE controle_fichas SET fb_2 = $select, fb_2_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb2);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_3'] == 0){
				$insert_fb3 = "UPDATE controle_fichas SET fb_3 = $select, fb_3_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb3);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_4'] == 0){
				$insert_fb4 = "UPDATE controle_fichas SET fb_4 = $select, fb_4_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb4);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_5'] == 0){
				$insert_fb5 = "UPDATE controle_fichas SET fb_5 = $select, fb_5_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb5);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_6'] == 0){
				$insert_fb6 = "UPDATE controle_fichas SET fb_6 = $select, fb_6_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb6);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_7'] == 0){
				$insert_fb7 = "UPDATE controle_fichas SET fb_7 = $select, fb_7_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb7);
				header("lista_telefonica.php");
			}
			
		}
		//$result_status = "UPDATE controle_fichas SET id_status_ligacao = $select, modified = NOW() WHERE id_controle = $idcontrole";
		//$resultado_status = mysqli_query($conn, $result_status);
		header("location: lista_telefonica.php");
	}else if($select == 7){
		$insert_desabilitar_ficha = "UPDATE controle_fichas SET id_status_sistema = 0, fb_1 = 7, fb_2 = 7, fb_3 = 7, fb_4 = 7, fb_5 = 7, fb_6 = 7, fb_7 = 7 WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_desabilitar_ficha);
				header("Location:lista_telefonica.php");
	}




?>