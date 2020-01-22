<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$select = $_POST['select_status'];
	$idcontrole = $_GET['idcontrole'];
	$usuario = $_SESSION['id_usuario'];
	$unidade = $_SESSION['unidade'];



	if($select == 2){
		$result_agenda = "SELECT * FROM controle_ligacao WHERE id_controle = $idcontrole";
		$resultado_agenda = mysqli_query($conn, $result_agenda);

		while($row_agenda = mysqli_fetch_assoc($resultado_agenda)){
		header("Location: ../cadastrar_agendamento_ligacao.php?idcontrole=".$row_agenda['id_controle']."&nomeresponsavel=".$row_agenda['nome_responsavel_controle']."&nomemodelo=".$row_agenda['nome_modelo_controle']."&telefoneprincipal=".$row_agenda['telefone_principal_controle']."&telefonesecundario=".$row_agenda['telefone_secundario_controle']."&idfuncionario=".$row_agenda['id_func']."&extracao=".$row_agenda['id_extracao']);
		};
	}else if($select == 3 || $select == 4 || $select == 6 || $select == 8 || $select == 5 || $select == 9){
		$select_n_fedback = "SELECT * FROM controle_fb_ligacao WHERE id_ficha = $idcontrole";
                                    $exec_select_n_fedback = mysqli_query($conn, $select_n_fedback);
                                    $qtd_select_n_fedback = mysqli_num_rows($exec_select_n_fedback);
                                    $qtd_final_n_fedback = $qtd_select_n_fedback + 1;

                                    $log_ficha_agendado = "INSERT controle_fb_ligacao(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha,status) VALUES ($usuario,$qtd_final_n_fedback,$unidade,NOW(),$idcontrole, $select)";
                                    mysqli_query($conn, $log_ficha_agendado);

        $update_ultimo_fedback = "UPDATE controle_ligacao SET ultimo_fedback = NOW(), qtd_feedback = '$qtd_final_n_fedback' WHERE id_controle = '$idcontrole'";
        $exec_update_ultimo_fedback = mysqli_query($conn, $update_ultimo_fedback);
        header("Location: ../lista_telefonica.php");
	}else if($select == 5 || $select == 7){
		header("Location:../motivo_ficha_si.php?idcontrole=$idcontrole");
		
	}





?>