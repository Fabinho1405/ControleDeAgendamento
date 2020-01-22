<?php
	session_start();
    ob_start();
    include_once("../conection/conexao.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $idclientereagendado = $_GET['id'];
    $dataagendada = $_POST['data_agendado'];
    $horaagendada = $_POST['hora_agendado'];
    $unidade = $_POST['select_unidade'];
    $contautilizada = $_POST['select_conta'];


    //Descobrir se o cliente é mesmo do usuário

    $verif_autenticidade = "SELECT * FROM cliente WHERE id_cliente = '$idclientereagendado' AND id_func = '$idfuncionario'";
    $verif_autenticidade_reagend = mysqli_query($conn, $verif_autenticidade);
    $row_verif_autenticidade = mysqli_num_rows($verif_autenticidade_reagend);
    if($row_verif_autenticidade > 0){
        if(empty($dataagendada)){
            $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Data do Agendamento!
                                    </div>";
                                    header("Location:../reagendar_cliente.php");
        }else if(empty($horaagendada)){
            $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Hora do Agendamento!
                                    </div>";
                                    header("Location:../reagendar_cliente.php");
        }else{

    	// Efetuar o reagendamento do cliente        
    	

    	//echo $dataagendada." - ".$horaagendada." - ".$unidade." - ".$idclientereagendado." - ".$contautilizada;

    	$data_agendamento_ajuste = date('Y-m-d', strtotime($dataagendada));
                                $inserir_agendamento = "INSERT INTO agendamentos (data_agendada_agendamento, hora_agendada_agendamento, data_cadastro_agendamento, id_cliente, id_status_sistema, id_func, id_comparecimento, id_conta_utilizada, id_unidade, reagendado, id_meio_captado) VALUES ('$data_agendamento_ajuste','$horaagendada',NOW(),'$idclientereagendado','1','$idfuncionario','3', '$contautilizada', '$unidade', '1', '1')";
                                $inserir_agendamento_resultado = mysqli_query($conn, $inserir_agendamento); 
                            $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
                            header("Location:../reagendar_cliente.php");



    }    	
    }else{
    	$_SESSION['msgcad'] = "<div class='alert-danger' role='alert'>
                                            <b> Tentativa de FRAUDE! LOG #14003 </b>
                             </div>";
                            header("Location:../reagendar_cliente.php");
    }






?>