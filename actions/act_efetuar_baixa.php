<?php
	session_start();
    ob_start();
	include_once("../conection/conexao.php");
	$idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
    $idlancamento = $_GET['id_lancamento'];
    $status = $_GET['situacao_lancamento'];
    $contrato = $_GET['ctn'];

    if($unidadefunc == 4){
    	if($status == 2){
    		$update_lancamento = "UPDATE lancamento_concept SET status_lancamento = '2', data_baixa_lancamento = NOW() WHERE id_lancamento = '$idlancamento'";
    		$exec_update = mysqli_query($conn, $update_lancamento);

    		$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                           Pagamento registrado com sucesso!</div>";
			header("Location:../inserir_pag_form.php?ctn=$contrato");
    	}else if($status == 3){
    		$update_lancamento = "UPDATE lancamento_concept SET status_lancamento = '3', data_baixa_lancamento = NOW() WHERE id_lancamento = '$idlancamento'";
    		$exec_update = mysqli_query($conn, $update_lancamento);

    		$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                           Re-Negociacao registrada com sucesso!Favor inserir a nova forma de pagamento na aba 'Inserir Pagamento' do contrato. </div>";
			header("Location:../inserir_pag_form.php?ctn=$contrato");
    	}else{

    	}
    }else{
        if($status == 2){
            $update_lancamento = "UPDATE lancamento_exclusive SET status_lancamento = '2', data_baixa_lancamento = NOW() WHERE id_lancamento = '$idlancamento'";
            $exec_update = mysqli_query($conn, $update_lancamento);

            $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                           Pagamento registrado com sucesso!</div>";
            header("Location:../inserir_pag_form.php?ctn=$contrato");
        }else if($status == 3){
            $update_lancamento = "UPDATE lancamento_exclusive SET status_lancamento = '3', data_baixa_lancamento = NOW() WHERE id_lancamento = '$idlancamento'";
            $exec_update = mysqli_query($conn, $update_lancamento);

            $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                           Re-Negociacao registrada com sucesso!Favor inserir a nova forma de pagamento na aba 'Inserir Pagamento' do contrato. </div>";
            header("Location:../inserir_pag_form.php?ctn=$contrato");
        }else{

        }
    }
?>