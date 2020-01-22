<?php
    session_start();
    ob_start();


	include_once("../conection/conexao.php");

	//GLOBAIS DE LOGIN
	$idfuncionario = $_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];

    //GLOBAIS DE PROCEDIMENTO
    $aut_contrato = $_SESSION['aut_contrato'];
    $contrato = $_SESSION['n_contrato'];
    $procedimento = $_SESSION['pcdm'];

    if($unidade == 1){
    	//Modifica Status do Contrato
        if($aut_contrato <> 6){
            if($aut_contrato == 1){
                $update_status_contrato = "UPDATE clientes_exclusive SET status_cc = '$aut_contrato', liberado_edicao = NOW(), data_enviado_analise = NOW() WHERE contrato_cc = '$contrato'";
                $exec_update_status = mysqli_query($conn, $update_status_contrato);
            }else{
            	$update_status_contrato = "UPDATE clientes_exclusive SET status_cc = '$aut_contrato', data_enviado_analise = NOW() WHERE contrato_cc = '$contrato'";
            	$exec_update_status = mysqli_query($conn, $update_status_contrato); 
        }
        }else{

        }
    	//Finaliza Procedimento do Dia
    	$update_fim_procedimento = "UPDATE estudio_exclusive SET atendimento_andamento_ec = '0', final_atendimento_ec = NOW(), atendimento_finalizado = '1', enviado_analise_ec = '1' WHERE id_ec = '$procedimento'";
    	$exec_fim_procedimento = mysqli_query($conn, $update_fim_procedimento);

    	//VERIFICA SE O MATERIAL VAI MESMO PARA A EDIÇÃO OU IRÁ PARA A FILA DE ESPERA, INSERIR NA TABELA DA EDIÇÃO O MATERIAL

    	//Destrói as globais de procedimento.
    	unset($_SESSION['aut_contrato']);
    	unset($_SESSION['n_contrato']);
    	unset($_SESSION['pcdm']);

    	//Encaminha para index e informa que foi lançado
    	header("Location: ../index.php");
    }else if($unidade == 4){
       //Modifica Status do Contrato
        if($aut_contrato <> 6){
            if($aut_contrato == 1){
                $update_status_contrato = "UPDATE clientes_concept SET status_cc = '$aut_contrato', liberado_edicao = NOW(), data_enviado_analise = NOW() WHERE contrato_cc = '$contrato'";
                $exec_update_status = mysqli_query($conn, $update_status_contrato);
            }else{
                $update_status_contrato = "UPDATE clientes_concept SET status_cc = '$aut_contrato', data_enviado_analise = NOW() WHERE contrato_cc = '$contrato'";
                $exec_update_status = mysqli_query($conn, $update_status_contrato); 
        }
        }else{

        }
        //Finaliza Procedimento do Dia
        $update_fim_procedimento = "UPDATE estudio_concept SET atendimento_andamento_ec = '0', final_atendimento_ec = NOW(), atendimento_finalizado = '1', enviado_analise_ec = '1' WHERE id_ec = '$procedimento'";
        $exec_fim_procedimento = mysqli_query($conn, $update_fim_procedimento);

        //VERIFICA SE O MATERIAL VAI MESMO PARA A EDIÇÃO OU IRÁ PARA A FILA DE ESPERA, INSERIR NA TABELA DA EDIÇÃO O MATERIAL

        //Destrói as globais de procedimento.
        unset($_SESSION['aut_contrato']);
        unset($_SESSION['n_contrato']);
        unset($_SESSION['pcdm']);

        //Encaminha para index e informa que foi lançado
        header("Location: ../index.php");

    }

?>