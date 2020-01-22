<?php
    session_start();
    ob_start();
	include_once("../conection/conexao.php"); 
	$idfuncionario = $_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];
    
    $etapa = $_GET['etp'];
    $acp = $_GET['acp'];
 


    if($unidade == 4){
    	if($etapa == 1){
    		// INICIA O ATENDIMENTO AO CLIENTE 
    		$update_acp = "UPDATE estudio_concept SET inicio_atendimento_ec = NOW(), liberado_espera_ec = '0', atendimento_andamento_ec = '1', func_atendimento_ec = '$idfuncionario' WHERE id_ec = '$acp'";
    		$exec_update_acp = mysqli_query($conn, $update_acp);
    		header("Location: ../processo_estudio.php?acp=$acp");
    	}else if($etapa == 2){
            $finaliza_atendimento = "UPDATE estudio_concept SET atendimento_andamento_ec = 0, final_atendimento_ec = NOW(), marcou_retorno_ec = 1, atendimento_finalizado = 1 WHERE id_ec = '$acp'";
            $exec_finaliza_atendimento = mysqli_query($conn, $finaliza_atendimento); 

            //INSERE O CADASTRO DE RETORNO
             $motivo_retorno = $_POST['select_motivo_estudio'];
             $contrato = $_GET['cnt'];
             $data = $_POST['data_agendado']; 
             $hora = $_POST['hora_agendado'];

             
            $verificaExiste = "SELECT * FROM retorno_concept WHERE contrato_cc = '$contrato' AND data_rt = '$data'";
            $exec_verificaExiste = mysqli_query($conn, $verificaExiste);
            $qtd_agnd = mysqli_num_rows($exec_verificaExiste);
            if($qtd_agnd >= 1){
            //INSERE O CADASTRO DE RETORNO
            
             $insert_retorno = "INSERT INTO retorno_concept (contrato_cc, motivo_retorno_rt, data_rt, horario_rt, compareceu_rt, func_marcou_rt, created) VALUES ('$contrato', '$motivo_retorno', '$data', '$hora', '0', '$idfuncionario', NOW())";
             $exec_insert_retorno = mysqli_query($conn, $insert_retorno);
             header("Location: ../pegar_procedimento_estudio.php");
            }else{
                 $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                                    Esse retorno já foi marcado na agenda. Verifique o calendário.
                                            </div>";
                header("Location: ../marcar_retorno.php"); 
            } 

        }else if($etapa == 3){
            //INSERE O ATENDIMENTO AO CLIENTE DA PRODUÇÃO
            $update_acp = "UPDATE estudio_concept SET inicio_atendimento_producao_ec = NOW(), liberado_espera_producao_ec = '0', atendimento_andamento_producao_ec = '1', func_atendimento_producao_ec = '$idfuncionario' WHERE id_ec = '$acp'";
            $exec_update_acp = mysqli_query($conn, $update_acp);
            header("Location: ../processo_producao.php?acp=$acp");
        }else if($etapa == 4){
            //ENCAMINHA DA PRODUÇÃO PARA O ESTÚDIO
            $update_acp = "UPDATE estudio_concept SET final_atendimento_producao_ec = NOW(), atendimento_andamento_producao_ec = '0', liberado_espera_ec = '1' WHERE id_ec = '$acp'";
            $exec_update_acp = mysqli_query($conn, $update_acp);
            header("Location:../pegar_procedimento_producao.php");
        }
    }else if($unidade == 1){
    	if($etapa == 1){
            // INICIA O ATENDIMENTO AO CLIENTE
            $update_acp = "UPDATE estudio_exclusive SET inicio_atendimento_ec = NOW(), liberado_espera_ec = '0', atendimento_andamento_ec = '1', func_atendimento_ec = '$idfuncionario' WHERE id_ec = '$acp'";
            $exec_update_acp = mysqli_query($conn, $update_acp);
            header("Location: ../processo_estudio.php?acp=$acp");

        }else if($etapa == 2){
            // MARCA RETORNO DO CLIENTE 
             $finaliza_atendimento = "UPDATE estudio_exclusive SET atendimento_andamento_ec = 0, final_atendimento_ec = NOW(), marcou_retorno_ec = 1, atendimento_finalizado = 1 WHERE id_ec = '$acp'";
            $exec_finaliza_atendimento = mysqli_query($conn, $finaliza_atendimento);
             $motivo_retorno = $_POST['select_motivo_estudio'];
             $contrato = $_GET['cnt'];
             $data = $_POST['data_agendado'];
             $hora = $_POST['hora_agendado'];

            $verificaExiste = "SELECT * FROM retorno_exclusive WHERE contrato_cc = '$contrato' AND data_rt = '$data'";
            $exec_verificaExiste = mysqli_query($conn, $verificaExiste);
            $qtd_agnd = mysqli_num_rows($exec_verificaExiste);
            if($qtd_agnd >= 1){
            //INSERE O CADASTRO DE RETORNO
            
             $insert_retorno = "INSERT INTO retorno_exclusive (contrato_cc, motivo_retorno_rt, data_rt, horario_rt, compareceu_rt, func_marcou_rt, created) VALUES ('$contrato', '$motivo_retorno', '$data', '$hora', '0', '$idfuncionario', NOW())";
             $exec_insert_retorno = mysqli_query($conn, $insert_retorno);
             header("Location: ../pegar_procedimento_estudio.php");
            }else{
                 $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                                    Esse retorno já foi marcado na agenda. Verifique o calendário.
                                            </div>";
                header("Location: ../marcar_retorno.php");
            }            
            //verifica se há procedimento no processo
            if($acp <> ""){           
            //FINALIZA O PROCEDIMENTO
            $finaliza_atendimento = "UPDATE estudio_exclusive SET atendimento_andamento_ec = 0, final_atendimento_ec = NOW(), marcou_retorno_ec = 1, atendimento_finalizado = 1 WHERE id_ec = '$acp'";
            $exec_finaliza_atendimento = mysqli_query($conn, $finaliza_atendimento);
            }else{

            };

            //INSERE O CADASTRO DE RETORNO
             $motivo_retorno = $_POST['select_motivo_estudio'];
             $contrato = $_GET['cnt'];
             $data = $_POST['data_agendado'];
             $hora = $_POST['hora_agendado'];
             $insert_retorno = "INSERT INTO retorno_exclusive (contrato_cc, motivo_retorno_rt, data_rt, horario_rt, compareceu_rt, func_marcou_rt, created) VALUES ('$contrato', '$motivo_retorno', '$data', '$hora', '0', '$idfuncionario', NOW())";
             $exec_insert_retorno = mysqli_query($conn, $insert_retorno);
             header("Location: ../");
        }else if($etapa == 3){
            //INSERE O ATENDIMENTO AO CLIENTE DA PRODUÇÃO
            $update_acp = "UPDATE estudio_exclusive SET inicio_atendimento_producao_ec = NOW(), liberado_espera_producao_ec = '0', atendimento_andamento_producao_ec = '1', func_atendimento_producao_ec = '$idfuncionario' WHERE id_ec = '$acp'";
            $exec_update_acp = mysqli_query($conn, $update_acp);
            header("Location: ../processo_producao.php?acp=$acp");
        }else if($etapa == 4){
            //ENCAMINHA DA PRODUÇÃO PARA O ESTÚDIO
            $update_acp = "UPDATE estudio_exclusive SET final_atendimento_producao_ec = NOW(), atendimento_andamento_producao_ec = '0', liberado_espera_ec = '1' WHERE id_ec = '$acp'";
            $exec_update_acp = mysqli_query($conn, $update_acp);
            header("Location:../pegar_procedimento_producao.php");
        }

    } 



?>