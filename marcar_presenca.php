<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_recepcao'] == 1){
    include_once("conection/conexao.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $idunidade = $_SESSION['unidade'];
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv=”content-type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Models Painel Admin</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/javascriptpersonalizado.js"></script>

     <link href="CSS/uploadfilemulti.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>
   <?php
        include_once("includes/inc_menu.php");
    ?>
    <div id="right-panel" class="right-panel">

        <!-- Header-->
         <?php
            include_once("includes/inc_header.php");
         ?><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><?php echo "São Paulo, ".date("d/m/Y"); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
<!--  INICIO PAGE  -->
        <?php

        //Receber o número da página
        $pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);       
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
        
        //Setar a quantidade de itens por pagina
        $qnt_result_pg = 1;
        
        //calcular o inicio visualização
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;    
        
        
            ?>
   
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12"> 
                    <div class="card"> 
                        <div class="card-header"> 
                            <?php                              
                                    if(isset($_SESSION['msgpres'])){
                                        echo $_SESSION['msgpres'];
                                        unset($_SESSION['msgpres']);
                                    };
                                $numero_agendamentos = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = date(NOW()) AND id_unidade = '$idunidade'";
                                $result_numero_agendamentos = mysqli_query($conn, $numero_agendamentos);
                                $qtd_final_agendamentos = mysqli_num_rows($result_numero_agendamentos);

                                if($idunidade == 1){
                                    $selecoes_dia = "SELECT * FROM trab_e_sele_exclusive WHERE data_marcada = date(NOW()) AND tipo = '1'";
                                    $exec_selecoes_dia = mysqli_query($conn, $selecoes_dia);
                                    $qtd_selecoes = mysqli_num_rows($exec_selecoes_dia);

                                    $trabalhos_dia = "SELECT * FROM trab_e_sele_exclusive WHERE data_marcada = date(NOW()) AND tipo = '2'";
                                    $exec_trabalhos_dia = mysqli_query($conn, $trabalhos_dia);
                                    $qtd_trabalhos = mysqli_num_rows($exec_trabalhos_dia);

                                    $retornos_dia = "SELECT * FROM retorno_exclusive WHERE data_rt = date(NOW())";
                                    $exec_retorno_dia = mysqli_query($conn, $retornos_dia);
                                    $qtd_retornos = mysqli_num_rows($exec_retorno_dia);

                                }else if($idunidade == 4){
                                    $selecoes_dia = "SELECT * FROM trab_e_sele_concept WHERE data_marcada = date(NOW()) AND tipo = '1'";
                                    $exec_selecoes_dia = mysqli_query($conn, $selecoes_dia);
                                    $qtd_selecoes = mysqli_num_rows($exec_selecoes_dia);

                                    $trabalhos_dia = "SELECT * FROM trab_e_sele_concept WHERE data_marcada = date(NOW()) AND tipo = '2'";
                                    $exec_trabalhos_dia = mysqli_query($conn, $trabalhos_dia);
                                    $qtd_trabalhos = mysqli_num_rows($exec_trabalhos_dia);

                                    $retornos_dia = "SELECT * FROM retorno_concept WHERE data_rt = date(NOW())";
                                    $exec_retorno_dia = mysqli_query($conn, $retornos_dia);
                                    $qtd_retornos = mysqli_num_rows($exec_retorno_dia);


                                }

                            ?>
                            <strong class="card-title"><a href="#"> Número de Agendados </a>: </strong><?php echo $qtd_final_agendamentos;?> | <strong><a href="#">Seleções</a>:</strong><?php echo $qtd_selecoes ?> | <strong><a href="#">Trabalhos</a>:</strong> <?php echo $qtd_trabalhos; ?> | <strong><a href="#">Retornos:</a> </strong> <?php echo $qtd_retornos; ?>
                             | <strong>Inserção de Emergência: </strong> <a href="insercaoEmergencia.php"> + </a>
                        </div>
                        <div class="card-body">
                            <center>
                            <form action="" method="POST">
                                <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Pesquisar Por:</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="filtrar_pesquisa" class="form-control">
                                    <option value="1">Agendamento</option>
                                    <option value="2">Retorno</option>  
                                    <option value="3">Seleção</option>
                                    <option value="4">Trabalho</option>                                                                   
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Filtrar Por:</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="filtro" class="form-control">
                                    <option value="1">Nome</option>
                                    <option value="2">Telefone</option>
                                    <option value="3">Contrato</option>                                                                     
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <input type="text" name="parametro" class="form-control" placeholder="Digite Aqui de Acordo com o Valor Escolhido Acima">
                            </div>       
                          </div>
                                <input type="submit" value="Pesquisar" class="btn btn-primary" name="enviar">                  
                            </form>
                            <br>



                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <?php
                            //vERIFICA SE O BOTÃO DO FORMULÁRIO FOI PRESSIONADO
                            if(!empty($_POST['enviar'])){
                                //CADASTRA AS VARIÁVEIS GERAIS
                                $filtro = $_POST['filtro'];
                                $parametro = $_POST['parametro'];

                                //VERIFICA QUAL É O TIPO DE PESQUISA
                                if($_POST['filtrar_pesquisa'] == 1){
                                    //INICIA PESQUISA COM RELAÇÃO AOS AGENDAMENTOS

                                    //EXIBE O TOPO DA TABELA
                        ?>
                                <thead>
                                  <tr>
                                    <th title="Identificação do Agendamento">#</th>
                                    <th title="Identificação do Cliente">#</th>
                                    <th>Modelo</th>
                                    <th>Responsável</th>
                                    <th>Telefone Principal</th>
                                    <th>Telefone Secundário</th>
                                    <th>Scouter</th>
                                    <th>Ação</th>
                                  </tr>
                                </thead>
                        <?php

                                //VERIFICA QUAL O FILTRO (nome, telefone, contrato)
                                    if($filtro == 1){
                                        //PESQUISA E EXIBE O RESULTADO POR NOME
                                        $pesquisa_ficha = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente INNER JOIN funcionario fun ON ag.id_func = fun.id_func WHERE ag.data_agendada_agendamento = date(NOW()) AND id_comparecimento <> '1' AND ag.id_unidade = '$idunidade' AND cli.nome_cliente LIKE '%$parametro%'";
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){

                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['id_agendamentos']; ?></td>
                                        <td><?php  echo $row_parametro['id_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['nome_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['telefone_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['telefone2_cliente'];?></td>
                                        <td><?php echo $row_parametro['nome_completo_func']; ?></td>                           
                                        <td>
                                        <?php  
                                            $idagd = $row_parametro['id_agendamentos'];

                                            echo "<a href='actions/act_confirmar_presenca.php?idagd=$idagd'> Compareceu </a>";
                                        ?> </td>
                                    </tr>
                        <?php
                                        };
                                    }else if($filtro == 2){
                                        //PESQUISA E EXIBE O RESULTADO POR TELEFONE
                                        $pesquisa_ficha = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente INNER JOIN funcionario fun ON ag.id_func = fun.id_func WHERE ag.data_agendada_agendamento = date(NOW()) AND id_comparecimento <> '1' AND ag.id_unidade = '$idunidade' AND cli.telefone_cliente LIKE '%$parametro%'";
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['id_agendamentos']; ?></td>
                                        <td><?php  echo $row_parametro['id_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['nome_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['telefone_cliente']; ?></td>
                                        <td><?php  echo $row_parametro['telefone2_cliente'];?></td>
                                        <td><?php echo $row_parametro['nome_completo_func']; ?></td>                           
                                        <td>
                                        <?php  
                                            $idagd = $row_parametro['id_agendamentos'];
                                            echo "<a href='actions/act_confirmar_presenca.php?idagd=$idagd'> Compareceu </a>";
                                        ?></td>
                                     </tr>
                        <?php
                                        };
                                    }else if($filtro == 3){
                        ?>
                                    <tr>
                                        <td colspan="10"> <center> Formato Não Suportado na Pesquisa Por <b> Agendamentos</b></center> </td>
                                    </tr>

                        <?php                                        
                                    };
                                }else if($_POST['filtrar_pesquisa'] == 2){
                                    //INICIA PESQUISA COM RELAÇÃO AOS RETORNOS

                                    //EXIBE O TOPO DA TABELA
                        ?>
                                <thead>
                                  <tr>
                                    <th title="">Contrato</th>
                                    <th title="">Modelo</th>
                                    <th>Responsável</th>
                                    <th>Produtor</th>
                                    <th>Motivo</th>
                                    <th>Horário Marcado</th>
                                    <th>Ação</th>
                                  </tr>
                                </thead>
                        <?php

                                //VERIFICA QUAL O FILTRO (nome, telefone, contrato)
                                    if($filtro == 1){
                                        //PESQUISA E EXIBE O RESULTADO POR NOME
                                        //VERIFICA A UNIDADE
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM retorno_exclusive re
                                            INNER JOIN funcionario fun ON re.func_marcou_rt = fun.id_func
                                            INNER JOIN clientes_exclusive ce ON re.contrato_cc = ce.contrato_cc
                                            INNER JOIN motivo_estudio me ON re.motivo_retorno_rt = me.id_me
                                            WHERE ce.nome_modelo_cc LIKE '%$parametro%' AND re.data_rt = date(NOW()) AND re.compareceu_rt = '0'
                                            ";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM retorno_concept re
                                            INNER JOIN funcionario fun ON re.func_marcou_rt = fun.id_func
                                            INNER JOIN clientes_concept ce ON re.contrato_cc = ce.contrato_cc
                                            INNER JOIN motivo_estudio me ON re.motivo_retorno_rt = me.id_me
                                            WHERE ce.nome_modelo_cc LIKE '%$parametro%' AND re.data_rt = date(NOW()) AND re.compareceu_rt = '0'
                                            ";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){

                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_me']; ?></td>
                                        <td><?php  echo $row_parametro['horario_rt'];?></td>                         
                                        <td>
                                        <?php  
                                            $idret = $row_parametro['id_rt'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_retorno.php?idret=$idret&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                    </tr>
                        <?php
                                        };
                                    }else if($filtro == 2){
                                        //PESQUISA E EXIBE O RESULTADO POR TELEFONE
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM retorno_exclusive re
                                            INNER JOIN funcionario fun ON re.func_marcou_rt = fun.id_func
                                            INNER JOIN clientes_exclusive ce ON re.contrato_cc = ce.contrato_cc
                                            INNER JOIN motivo_estudio me ON re.motivo_retorno_rt = me.id_me
                                            WHERE re.data_rt = date(NOW()) AND re.compareceu_rt = '0' AND ce.telefone_residencial_cc LIKE '%$parametro%' OR re.data_rt = date(NOW()) AND re.compareceu_rt = '0' AND ce.telefone_celular_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM retorno_concept re
                                            INNER JOIN funcionario fun ON re.func_marcou_rt = fun.id_func
                                            INNER JOIN clientes_concept ce ON re.contrato_cc = ce.contrato_cc
                                            INNER JOIN motivo_estudio me ON re.motivo_retorno_rt = me.id_me
                                            WHERE re.data_rt = date(NOW()) AND re.compareceu_rt = '0' AND ce.telefone_residencial_cc LIKE '%$parametro%' OR re.data_rt = date(NOW()) AND re.compareceu_rt = '0' AND ce.telefone_celular_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_me']; ?></td>
                                        <td><?php  echo $row_parametro['horario_rt'];?></td>                         
                                        <td>
                                        <?php  
                                            $idret = $row_parametro['id_rt'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_retorno.php?idret=$idret&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                    </tr>
                        <?php
                                        };
                                    }else if($filtro == 3){
                                        //PESQUISA E EXIBE O RESULTADO POR CONTRATO
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM retorno_exclusive re
                                        INNER JOIN funcionario fun ON re.func_marcou_rt = fun.id_func
                                        INNER JOIN clientes_exclusive ce ON re.contrato_cc = ce.contrato_cc
                                        INNER JOIN motivo_estudio me ON re.motivo_retorno_rt = me.id_me
                                        WHERE ce.contrato_cc LIKE '%$parametro%' AND re.data_rt = date(NOW()) AND re.compareceu_rt = '0'";
                                        }else if($idunidade == 4){
                                             $pesquisa_ficha = "SELECT * FROM retorno_concept re
                                        INNER JOIN funcionario fun ON re.func_marcou_rt = fun.id_func
                                        INNER JOIN clientes_concept ce ON re.contrato_cc = ce.contrato_cc
                                        INNER JOIN motivo_estudio me ON re.motivo_retorno_rt = me.id_me
                                        WHERE ce.contrato_cc LIKE '%$parametro%' AND re.data_rt = date(NOW()) AND re.compareceu_rt = '0'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_me']; ?></td>
                                        <td><?php  echo $row_parametro['horario_rt'];?></td>                         
                                        <td>
                                        <?php  
                                            $idret = $row_parametro['id_rt'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_retorno.php?idret=$idret&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                    </tr>
                        <?php
                                        };                                 
                                    };


                                }else if($_POST['filtrar_pesquisa'] == 3){
                                    //INICIA A PESQUISA COM RELAÇÃO AS SELEÇÕES

                                    //EXIBE O TOPO DA TABELA
                        ?>
                                <thead>
                                  <tr>
                                    <th title="">Contrato</th>
                                    <th title="">Modelo</th>
                                    <th>Responsável</th>
                                    <th>Produtor</th>
                                    <th>Marca</th>
                                    <th>Horário Marcado</th>
                                    <th>Ação</th>
                                  </tr>
                                </thead>
                        <?php

                                //VERIFICA QUAL O FILTRO (nome, telefone, contrato)
                                    if($filtro == 1){
                                        //PESQUISA E EXIBE O RESULTADO POR NOME
                                        //VERIFICA A UNIDADE
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_exclusive ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_exclusive ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ce.nome_modelo_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_concept ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_concept ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ce.nome_modelo_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){

                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_marcas']; ?></td>
                                        <td><?php  echo $row_parametro['hora_marcada'];?></td>                         
                                        <td>
                                        <?php  
                                            $idts = $row_parametro['id_ts'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_presenca_sel_trab.php?pcdm=1&idts=$idts&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                    </tr>
                        <?php
                                        };
                                    }else if($filtro == 2){
                                        //PESQUISA E EXIBE O RESULTADO POR TELEFONE
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_exclusive ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_exclusive ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ce.telefone_residencial_cc LIKE '%$parametro%' OR data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ce.telefone_celular_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_concept ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_concept ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ce.telefone_residencial_cc LIKE '%$parametro%' OR data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ce.telefone_celular_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_marcas']; ?></td>
                                        <td><?php  echo $row_parametro['hora_marcada'];?></td>                         
                                        <td>
                                        <?php  
                                            $idts = $row_parametro['id_ts'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_presenca_sel_trab.php?pcdm=1&idts=$idts&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                     </tr>
                        <?php
                                        };
                                    }else if($filtro == 3){
                                        //PESQUISA E EXIBE O RESULTADO POR CONTRATO
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_exclusive ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_exclusive ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ts.contrato_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                             $pesquisa_ficha = "SELECT * FROM trab_e_sele_concept ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_concept ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '1' AND ts.compareceu = '0' AND ts.contrato_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_marcas']; ?></td>
                                        <td><?php  echo $row_parametro['hora_marcada'];?></td>                         
                                        <td>
                                        <?php  
                                            $idts = $row_parametro['id_ts'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_presenca_sel_trab.php?pcdm=1&idts=$idts&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                     </tr>
                        <?php
                                        };                                 
                                    };

                                }else if($_POST['filtrar_pesquisa'] == 4){
                                    //INICIA A PESQUISA COM RELAÇÃO AOS TRABALHOS
                                    //EXIBE O TOPO DA TABELA
                        ?>
                                <thead>
                                  <tr>
                                    <th title="">Contrato</th>
                                    <th title="">Modelo</th>
                                    <th>Responsável</th>
                                    <th>Produtor</th>
                                    <th>Marca</th>
                                    <th>Horário Marcado</th>
                                    <th>Ação</th>
                                  </tr>
                                </thead>
                        <?php

                                //VERIFICA QUAL O FILTRO (nome, telefone, contrato)
                                    if($filtro == 1){
                                        //PESQUISA E EXIBE O RESULTADO POR NOME
                                        //VERIFICA A UNIDADE
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_exclusive ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_exclusive ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '2'AND ts.compareceu = '0' AND ce.nome_modelo_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_concept ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_concept ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '2'AND ts.compareceu = '0' AND ce.nome_modelo_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){

                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_marcas']; ?></td>
                                        <td><?php  echo $row_parametro['hora_marcada'];?></td>                         
                                        <td>
                                        <?php  
                                            $idts = $row_parametro['id_ts'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_presenca_sel_trab.php?pcdm=2&idts=$idts&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                    </tr>
                        <?php
                                        };
                                    }else if($filtro == 2){
                                        //PESQUISA E EXIBE O RESULTADO POR TELEFONE
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_exclusive ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_exclusive ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '2' AND ce.telefone_residencial_cc LIKE '%$parametro%' OR data_marcada = date(NOW()) AND ts.tipo = '2' AND ts.compareceu = '0' AND ce.telefone_celular_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_concept ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_concept ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.tipo = '2' AND ce.telefone_residencial_cc LIKE '%$parametro%' OR data_marcada = date(NOW()) AND ts.tipo = '2' AND ts.compareceu = '0' AND ce.telefone_celular_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_marcas']; ?></td>
                                        <td><?php  echo $row_parametro['hora_marcada'];?></td>                         
                                        <td>
                                        <?php  
                                            $idts = $row_parametro['id_ts'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_presenca_sel_trab.php?pcdm=2&idts=$idts&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                     </tr>
                        <?php
                                        };
                                    }else if($filtro == 3){
                                        //PESQUISA E EXIBE O RESULTADO POR CONTRATO
                                        if($idunidade == 1){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_exclusive ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_exclusive ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.compareceu = '0' AND ts.tipo = '2' AND ts.contrato_cc LIKE '%$parametro%'";
                                        }else if($idunidade == 4){
                                            $pesquisa_ficha = "SELECT * FROM trab_e_sele_concept ts
                                                                INNER JOIN funcionario fun ON ts.id_produtor = fun.id_func
                                                                INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas
                                                                INNER JOIN clientes_concept ce ON ts.contrato_cc = ce.contrato_cc
                                                                WHERE data_marcada = date(NOW()) AND ts.compareceu = '0' AND ts.tipo = '2' AND ts.contrato_cc LIKE '%$parametro%'";
                                        }
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                    <tr>
                                        <td><?php  echo $row_parametro['contrato_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_modelo_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_responsavel_cc']; ?></td>
                                        <td><?php  echo $row_parametro['nome_completo_func']; ?></td>
                                        <td><?php  echo $row_parametro['descricao_marcas']; ?></td>
                                        <td><?php  echo $row_parametro['hora_marcada'];?></td>                         
                                        <td>
                                        <?php  
                                            $idts = $row_parametro['id_ts'];
                                            $contrato = $row_parametro['contrato_cc'];
                                            echo "<a href='actions/act_confirmar_presenca_sel_trab.php?pcdm=2&idts=$idts&cnt=$contrato'> Compareceu </a>";
                                        ?> </td>
                                     </tr>
                        <?php
                                        };                                 
                                    };
                                };
                            };

                        ?>

                        <tbody>
                            



                      
                        </tbody>
                  </table>
                            
                        </center>
                    </tbody>
                   
                
                  
                        </div>
                    </div>
                </div>
                </div>
            </div><!-- .animated -->
<!-- FIM PAGE -->      
            </div>
        </div>
        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.min.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="assets/js/lib/vector-map/country/jquery.vmap.world.js"></script>
    <script>
        ( function ( $ ) {
            "use strict";

            jQuery( '#vmap' ).vectorMap( {
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: [ '#1de9b6', '#03a9f5' ],
                normalizeFunction: 'polynomial'
            } );
        } )( jQuery );



    </script>

</body>
</html>
<script src="JS/jquery.fileuploadmulti.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
     {

     var settings = {
        url: "importar.php",
        method: "POST",
        allowedTypes:"jpg",
        fileName: "file",
        multiple: true,
        
        onSuccess:function(files,data,xhr)
        {
           //faz alguma coisa

        },
     
         afterUploadAll:function()
         {
            $(".upload-bar").css("animation-play-state","paused");
            
         },
        onError: function(files,status,errMsg)
        {       
          
            alert(errMsg);
        }

        
     }
     $("#mulitplefileuploader").uploadFile(settings);
        
     });
</script>
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>