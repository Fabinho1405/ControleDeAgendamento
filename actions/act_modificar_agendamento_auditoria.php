<?php
	session_start();
    ob_start();
	include_once("../conection/conexao.php");
	$idagendamento = $_GET['idagdm'];
	$select_agendamento = "SELECT * FROM agendamentos ag 
                            INNER JOIN conta_utilizada cu ON ag.id_conta_utilizada = cu.id_conta_utilizada
                            INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente
                            INNER JOIN meio_captado mc ON ag.id_meio_captado = mc.id_meio_captado
                            INNER JOIN unidade un ON ag.id_unidade = un.id_unidade
                            INNER JOIN funcionario fun ON ag.id_func = fun.id_func
                            WHERE id_agendamentos = '$idagendamento'";
    $exec_select_agendamento = mysqli_query($conn, $select_agendamento);
    $row_agendamento = mysqli_fetch_assoc($exec_select_agendamento);
    $idcliente = $row_agendamento['id_cliente'];
    $log = "modificou AG: $idagendamento | CLI: $idcliente | modificacao -> ";
    //Verifica se teve nome alterao
    if($row_agendamento['nome_cliente'] <> $_POST['nome_completo_cliente']){
        $log .= "nome_ANT:".$row_agendamento['nome_cliente']."-nome_MOD:".$_POST['nome_completo_cliente'];
        //UPDATE DO NOME
        $novo_nome = $_POST['nome_completo_cliente'];
        $update_mudanca = "UPDATE cliente SET nome_cliente = '$novo_nome', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se teve idade alterado
    if($row_agendamento['idade_cliente'] <> $_POST['idade_cliente']){
        $log .= "idade_ANT:".$row_agendamento['idade_cliente']."-idade_MOD:".$_POST['idade_cliente'];
        //UPDATE DA IDADE
        $nova_idade = $_POST['idade_cliente'];
        $update_mudanca = "UPDATE cliente SET idade_cliente = '$nova_idade', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se teve o telefone alterado
    if($row_agendamento['telefone_cliente'] <> $_POST['telefone_cliente']){
        $log .= " | tel_ANT:".$row_agendamento['telefone_cliente']."-tel_MOD:".$_POST['telefone_cliente'];
        //UPDATE DO NOME
        $novo_telefone = $_POST['telefone_cliente'];
        $update_mudanca = "UPDATE cliente SET telefone_cliente = '$novo_telefone', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se teve o telefone 2 alterado
    if($row_agendamento['telefone2_cliente'] <> $_POST['telefone2_cliente']){
        $log .= " | tel2_ANT:".$row_agendamento['telefone_cliente']."-tel2_MOD:".$_POST['telefone_cliente'];
        //UPDATE DO NOME
        $novo_telefone2 = $_POST['telefone2_cliente'];
        $update_mudanca = "UPDATE cliente SET telefone2_cliente = '$novo_telefone2', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se o responsável foi modificado
    if($row_agendamento['nome_responsavel_cliente'] <> $_POST['responsavel_cliente']){
        $log .= " | resp_ANT:".$row_agendamento['nome_responsavel_cliente']."-resp_MOD:".$_POST['responsavel_cliente'];
        //UPDATE DO NOME
        $novo_nome = $_POST['responsavel_cliente'];
        $update_mudanca = "UPDATE cliente SET nome_responsavel_cliente = '$novo_nome', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se o email foi modificado
    if($row_agendamento['email_cliente'] <> $_POST['email_cliente']){
        $log .= " | email_ANT:".$row_agendamento['email_cliente']."-email_MOD:".$_POST['email_cliente'];
        //UPDATE DO NOME
        $novo_email = $_POST['email_cliente'];
        $update_mudanca = "UPDATE cliente SET email_cliente = '$novo_email', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se a conta de captação foi modificada
    if($row_agendamento['id_conta_utilizada'] <> $_POST['select_conta']){
        $id_conta = $_POST['select_conta'];
        $select_conta = "SELECT * FROM conta_utilizada WHERE id_conta_utilizada = '$id_conta'";
        $exec_select_conta = mysqli_query($conn, $select_conta);
        $row_conta_agendamento = mysqli_fetch_assoc($exec_select_conta);
        $desc_conta = $row_conta_agendamento['nome_conta_utilizada'];

        $log .= " | conta_ANT:".$row_agendamento['id_conta_utilizada']."/".$row_agendamento['nome_conta_utilizada']."-conta_MOD:".$_POST['select_conta']."/".$desc_conta;
        //UPDATE DO NOME
        $nova_conta = $_POST['select_conta'];
        $update_mudanca = "UPDATE agendamentos SET id_conta_utilizada = '$nova_conta', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");

    }else{

    }
    //Verifica se o URL do instagram foi modificado
    if($row_agendamento['url_instagram'] <> $_POST['instagram_cliente']){
        $log .= " | URL_ANT:".$row_agendamento['url_instagram']."-URL_MOD:".$_POST['instagram_cliente'];
        //UPDATE DO NOME
        $novo_url = $_POST['instagram_cliente'];
        $update_mudanca = "UPDATE cliente SET url_instagram = '$novo_url', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");
    }else{

    }
    //Verifica se a UNIDADE foi modificada
    if($row_agendamento['id_unidade'] <> $_POST['select_unidade']){
        $id_unidade = $_POST['select_unidade'];
        $select_unidade = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
        $exec_select_unidade = mysqli_query($conn, $select_unidade);
        $row_unidade_agendamento = mysqli_fetch_assoc($exec_select_unidade);
        $desc_unidade = $row_unidade_agendamento['desc_unidade'];

        $log .= " | unid_ANT:".$row_agendamento['id_unidade']."/".$row_agendamento['desc_unidade']."-unid_MOD:".$_POST['select_unidade']."/".$desc_unidade;
        //UPDATE DO NOME
        $nova_unidade = $_POST['select_unidade'];
        $update_mudanca = "UPDATE agendamentos SET id_unidade = '$nova_unidade', modified = NOW() WHERE id_cliente = '$idcliente'";
        $exec_update_mudanca = mysqli_query($conn, $update_mudanca);
        $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
        header("Location:../modificar_cliente.php?idagdm=$idagendamento");

    }else{

    }
    //REGISTRA O LOG
    //LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', '$log', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
         //FIM LOG


    echo $log;

?>