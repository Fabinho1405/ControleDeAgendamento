<?php 
    session_start();
    ob_start();
	include_once("../conection/conexao.php");

    $idFuncionario = $_SESSION['id_usuario'];
    $unidadeFunc = $_SESSION['unidade'];

    //POST 
    $metodoCaptacao=$_POST['metodoCaptacao'];
    $qtdAgendamentos=$_POST['qtd_fichas'];
    $idColaborador=$_POST['idColaborador'];

    echo $metodoCaptacao."-".$qtdAgendamentos."-".$idColaborador."-".$idFuncionario."-".$unidadeFunc."<br>";

    $updateAgendamento="UPDATE agendamentos SET func_recuperacao='$idColaborador', dataLiberadaRecuperacao=NOW() WHERE date(data_agendada_agendamento) >= '2019-10-01' AND date(data_agendada_agendamento) < date(NOW()) AND id_unidade='$unidadeFunc' AND id_comparecimento='3' AND func_recuperacao='0' AND id_meio_captado='$metodoCaptacao' LIMIT $qtdAgendamentos ";
    $exec_update_agendamento=mysqli_query($conn, $updateAgendamento);

    $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                            Agendamento Liberado com Sucesso! 
                             </div>";

    header("Location: ../liberarAgendamentos.php");
?>