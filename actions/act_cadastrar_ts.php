<?php
    session_start();
    ob_start();

    include_once("../conection/conexao.php");

    //GLOBAIS
    $idfuncionario = $_SESSION['id_usuario']; 
    $unidadefunc = $_SESSION['unidade'];

    //GET QUE IDENTIFICA SE É TRABALHO OU SELEÇÃO
    $tipo = $_GET['tp'];

    //POST'S DO FORM
    $contrato = $_POST['contrato_ts'];
    $marca = $_POST['marca_ts'];
    $data = $_POST['data_ts'];
    $hora = $_POST['hora_ts'];
    $tipo_cache = $_POST['tipo_cache_ts'];
    $valor_cache = $_POST['valor_ts'];

    //LIMITADOR DE TRABALHOS
    $max_selecao_exclusive = 50;
    $max_trabalho_exclusive = 50; 


    //FORM SELEÇÃO
        if($tipo == 1){
        //ENTRA NO TIPO DE SELEÇÕES, E VERIFICA UNIDADE
            if($unidadefunc == 1){
                $select_selecoes = "SELECT * FROM trab_e_sele_exclusive WHERE data_marcada = '$data' AND tipo = '1'";
                $exec_selecoes = mysqli_query($conn, $select_selecoes);
                $qtd_selecoes = mysqli_num_rows($exec_selecoes);
                    if($qtd_selecoes < $max_selecao_exclusive){
                        //Cadastra seleção exclusive
                        $inserir_selecao = "INSERT INTO trab_e_sele_exclusive (contrato_cc, id_marcas, id_produtor, data_marcada, hora_marcada, tipo, compareceu,created) VALUES ('$contrato', '$marca', '$idfuncionario', '$data', '$hora', '1', '0', NOW())";
                        $exec_insert_selecao = mysqli_query($conn, $inserir_selecao);
                        $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                                    Seleção Encaminhada com Sucesso!
                                            </div>";
                        header("Location: ../encaminha_selecao.php");
                    }else{
                        $_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                                    Agenda do Estúdio Lotada para Esse Dia. Por Favor, selecione outra data.
                                            </div>";
                        header("Location: ../encaminha_selecao.php");
                    }
            }else if($unidadefunc == 4){
                 $select_selecoes = "SELECT * FROM trab_e_sele_concept WHERE data_marcada = '$data' AND tipo = '1'";
                $exec_selecoes = mysqli_query($conn, $select_selecoes);
                $qtd_selecoes = mysqli_num_rows($exec_selecoes);
                    if($qtd_selecoes < $max_selecao_exclusive){
                        //Cadastra seleção exclusive
                        $inserir_selecao = "INSERT INTO trab_e_sele_concept (contrato_cc, id_marcas, id_produtor, data_marcada, hora_marcada, tipo, compareceu,created) VALUES ('$contrato', '$marca', '$idfuncionario', '$data', '$hora', '1', '0', NOW())";
                        $exec_insert_selecao = mysqli_query($conn, $inserir_selecao);
                        $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                                    Seleção Encaminhada com Sucesso!
                                            </div>";
                        header("Location: ../encaminha_selecao.php");
                    }else{
                        $_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                                    Agenda do Estúdio Lotada para Esse Dia. Por Favor, selecione outra data.
                                            </div>";
                        header("Location: ../encaminha_selecao.php");
                    } 
                    }
               

            
        }else if($tipo == 2){
        //ENTRA NO TIPO DE TRABALHOS, E VERIFICA UNIDADE
            if($unidadefunc == 1){
                $select_selecoes = "SELECT * FROM trab_e_sele_exclusive WHERE data_marcada = '$data' AND tipo = '2'";
                $exec_selecoes = mysqli_query($conn, $select_selecoes);
                $qtd_selecoes = mysqli_num_rows($exec_selecoes);
                    if($qtd_selecoes < $max_trabalho_exclusive){
                        //Cadastra seleção exclusive
                        $inserir_selecao = "INSERT INTO trab_e_sele_exclusive VALUES (NULL, '$contrato', '$marca', '$idfuncionario', '$data', '$hora','$tipo_cache', '$valor_cache', '2', '0', NULL, NOW())";
                        $exec_insert_selecao = mysqli_query($conn, $inserir_selecao);
                        $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                                    Trabalho Encaminhado com Sucesso!
                                            </div>";
                        header("Location: ../encaminha_trabalho.php");
                    }else{
                        $_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                                    Agenda do Estúdio Lotada para Esse Dia. Por Favor, selecione outra data.
                                            </div>";
                        header("Location: ../encaminha_trabalho.php");
                    };
            }else if($unidadefunc == 4){
                $select_selecoes = "SELECT * FROM trab_e_sele_concept WHERE data_marcada = '$data' AND tipo = '2'";
                $exec_selecoes = mysqli_query($conn, $select_selecoes);
                $qtd_selecoes = mysqli_num_rows($exec_selecoes);
                    if($qtd_selecoes < $max_trabalho_exclusive){
                        //Cadastra seleção exclusive
                        $inserir_selecao = "INSERT INTO trab_e_sele_concept VALUES (NULL, '$contrato', '$marca', '$idfuncionario', '$data', '$hora','$tipo_cache', '$valor_cache', '2', '0', NULL, NOW())";
                        $exec_insert_selecao = mysqli_query($conn, $inserir_selecao);
                        $_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>
                                                    Trabalho Encaminhado com Sucesso!
                                            </div>";
                        header("Location: ../encaminha_trabalho.php");
                    }else{
                        $_SESSION['msg_cad'] = "<div class='alert alert-danger' role='alert'>
                                                    Agenda do Estúdio Lotada para Esse Dia. Por Favor, selecione outra data.
                                            </div>";
                        header("Location: ../encaminha_trabalho.php");
                    };

            }

        }






?>