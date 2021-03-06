<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1){
    include_once("conection/conexao.php");
    include_once("conection/connection.php");
    $pdo=conectar();
    include_once("php/verificar_sessao.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
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
         ?> 
      <!-- /header -->
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
<!--  INICIO DE FORM DE CADASTRO  -->
     <?php
                        if(isset($_SESSION['msgcad'])){
                            echo $_SESSION['msgcad'];
                            unset($_SESSION['msgcad']);
                        };
                        ?>

        <div class="content mt-3">
            <div class="col-sm-12" >
                <div class="col-lg-6">
                    <div class="card" style="max-width: 900px; width: 800px;">
                      <div class="card-header" style="max-width: 900px; width: 800px;">
                        
                        <?php
                            $ncontrato = $_GET['ncontrato'];
                            if($unidadefunc == 1){
                              //PESQUISA CONTRATO
                              $select_contrato = "SELECT * FROM clientes_exclusive cc 
                              INNER JOIN funcionario func ON cc.id_produtor = func.id_func
                              INNER JOIN status_contrato sc ON cc.status_cc = sc.id_sc
                              WHERE cc.contrato_cc = '$ncontrato'";
                              $exec_select_contrato = mysqli_query($conn, $select_contrato);

                              $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

                              //PESQUISA LANÇAMENTOS
                              $select_lancamento = "SELECT * FROM lancamento_exclusive lc
                              INNER JOIN funcionario func ON lc.func_lancamento = func.id_func
                              INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento
                              INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp
                              WHERE lc.n_contrato_lancamento = '$ncontrato' AND status = '1'";
                              $exec_select_lancamento = mysqli_query($conn, $select_lancamento);

                              //PESQUISA DE TRABALHOS E SELEÇÕS PDO
                              $selectTs=$pdo->prepare("SELECT * FROM trab_e_sele_exclusive tsc INNER JOIN clientes_exclusive cc ON tsc.contrato_cc = cc.contrato_cc INNER JOIN marcas ma ON tsc.id_marcas = ma.id_marcas INNER JOIN funcionario func ON tsc.id_produtor = func.id_func WHERE tsc.contrato_cc=:contrato");
                              $selectTs->bindValue(":contrato", $ncontrato, PDO::PARAM_INT);
                              $selectTs->execute();

                              //PESQUISA SOBRE CURSOS

                            }else if($unidadefunc == 4){ 

                              //PESQUISA CONTRATO
                              $select_contrato = "SELECT * FROM clientes_concept cc 
                              INNER JOIN funcionario func ON cc.id_produtor = func.id_func
                              INNER JOIN status_contrato sc ON cc.status_cc = sc.id_sc
                              WHERE cc.contrato_cc = '$ncontrato'";
                              $exec_select_contrato = mysqli_query($conn, $select_contrato);

                              $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

                              //PESQUISA LANÇAMENTOS
                              $select_lancamento = "SELECT * FROM lancamento_concept lc
                              INNER JOIN funcionario func ON lc.func_lancamento = func.id_func
                              INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento
                              INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp
                              WHERE lc.n_contrato_lancamento = '$ncontrato' AND status = '1'";
                              $exec_select_lancamento = mysqli_query($conn, $select_lancamento);

                              //PESQUISA DE TRABALHOS E SELEÇÕS PDO
                              $selectTs=$pdo->prepare("SELECT * FROM trab_e_sele_concept tsc INNER JOIN clientes_concept cc ON tsc.contrato_cc = cc.contrato_cc INNER JOIN marcas ma ON tsc.id_marcas = ma.id_marcas INNER JOIN funcionario func ON tsc.id_produtor = func.id_func WHERE tsc.contrato_cc=:contrato");
                              $selectTs->bindValue(":contrato", $ncontrato, PDO::PARAM_INT);
                              $selectTs->execute();

                              //PESQUISA SOBRE CURSOS
                              $selectCurso=$pdo->prepare(""); 
                            }
                            $rowTs=$selectTs->fetchall(PDO::FETCH_OBJ);
                        ?>   
                        <strong>Contrato</strong> Detalhado &nbsp;&nbsp;&nbsp;                   
                      </div>
                      <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="custom-tab"> 

                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active show" id="custom-nav-detalhes-tab" data-toggle="tab" href="#custom-nav-detalhes" role="tab" aria-controls="custom-nav-detalhes" aria-selected="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Detalhes</font></font></a>

                                                <a class="nav-item nav-link" id="custom-nav-material-tab" data-toggle="tab" href="#custom-nav-material" role="tab" aria-controls="custom-nav-material" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Material</font></font></a>

                                                <a class="nav-item nav-link" id="custom-nav-embolso-tab" data-toggle="tab" href="#custom-nav-embolso" role="tab" aria-controls="custom-nav-embolso" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Embolso</font></font></a>

                                                <a class="nav-item nav-link" id="custom-nav-ts-tab" data-toggle="tab" href="#custom-nav-ts" role="tab" aria-controls="custom-nav-ts" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Trabalhos e Seleções</font></font></a>

                                                <a class="nav-item nav-link" id="custom-nav-cursos-tab" data-toggle="tab" href="#custom-nav-cursos" role="tab" aria-controls="custom-nav-cursos" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cursos</font></font></a>
                                                <a class="nav-item nav-link" id="custom-nav-prod-tab" data-toggle="tab" href="#custom-nav-prod" role="tab" aria-controls="custom-nav-prod" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Histórico de Produção</font></font></a>
                                            </div>
                                        </nav>

                                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                            <div class="tab-pane fade active show" id="custom-nav-detalhes" role="tabpanel" aria-labelledby="custom-nav-detalhes-tab">
                                                <div class="row form-group">
                                                  <div class="col col-md-3"><label class=" form-control-label" style="text-align: right;"><b>Contrato:</b></label></div>
                                                  <div class="col-12 col-md-3">                                                   
                                                    <label style="text-align: left;">
                                                    <?php
                                                      echo $row_contrato['contrato_cc'];
                                                    ?>
                                                    <?php
                                                    if($_SESSION['menu_recepcao'] == 1){
                                                   ?>
                                                    <a href="#" onclick="window.open('modificar_contrato_basico.php?ncontrato=<?php echo $ncontrato; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=30, LEFT=70, WIDTH=1000, HEIGHT=800');"><img src='images/edit.png' width='32px' height='32px'></a> 
                                                    <a href="#" onclick="window.open('modificar_contrato.php?ncontrato=<?php echo $ncontrato; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=30, LEFT=70, WIDTH=1000, HEIGHT=800');"><img src='images/config_advanced.png' width='32px' height='32px'></a>   
                                                  </label>
                                                  <?php
                                                    };
                                                  ?>
                                                  </div> 
                                                   <div class="col col-md-3"><label class=" form-control-label" style="text-align: right;"><b>Status:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <label style="text-align: left;">
                                                    <?php
                                                      echo $row_contrato['descricao_sc'];
                                                    ?>
                                                  </label>
                                                  </div>                             
                                                </div>

                                                <div class="row form-group">
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>Nome do Modelo:</b></label></div>
                                                  <div class="col-12 col-md-9">
                                                    <?php
                                                      echo $row_contrato['nome_modelo_cc'];
                                                    ?>
                                                  </div>                          
                                                </div>
                                                  <div class="row form-group">
                                                  <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Rg do Modelo:</b></label></div>
                                                  <div class="col-12 col-md-3">   
                                                  <?php
                                                    echo $row_contrato['rg_modelo_cc'];
                                                  ?>
                                                  </div>
                                                  <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>CPF do Modelo:</b></label></div>
                                                  <div class="col-12 col-md-3">   
                                                  <?php
                                                    echo $row_contrato['cpf_modelo_cc'];
                                                  ?>
                                                  </div>
                                                </div>

                                                <?php 
                                                  if($row_contrato['idade_cc'] < 18){
                                                ?>
                                                <div class="row form-group">
                                                  <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Responsável:</b></label></div>
                                                  <div class="col-12 col-md-9">
                                                    <?php
                                                      echo $row_contrato['nome_responsavel_cc'];
                                                    ?>
                                                  </div>
                                                </div> 
                                                <div class="row form-group">
                                                  <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Rg do Responsável:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php
                                                      echo $row_contrato['rg_responsavel_cc'];
                                                    ?>
                                                  </div>
                                                  <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>CPF do Responsável:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php
                                                      echo $row_contrato['cpf_responsavel_cc'];
                                                    ?>
                                                  </div>
                                                </div> 
                                                <?php
                                                  };
                                                ?>                                                
                                                <div class="row form-group">
                                                   <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Telefone Principal:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php
                                                    if(!empty($row_contrato['telefone_residencial_cc'])){
                                                      echo $row_contrato['telefone_residencial_cc'];
                                                    }else{
                                                      echo "Não Possui";
                                                    }
                                                    ?>
                                                  </div>
                                                  <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Telefone Secundário:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php
                                                    if(!empty($row_contrato['telefone_celular_cc'])){
                                                      echo $row_contrato['telefone_celular_cc'];
                                                    }else{
                                                      echo "Não Possui";
                                                    }
                                                    ?>
                                                  </div>
                                                </div>              
                                                <div class="row form-group">
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>Data de Nascimento:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php 
                                                      echo date('d/m/Y', strtotime($row_contrato['nascimento_cc']));
                                                    ?>
                                                  </div>
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>Idade:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php 
                                                      echo $row_contrato['idade_cc'];
                                                    ?>
                                                  </div>
                                                </div>   
                                                <div class="row form-group">
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>Endereço:</b></label></div>
                                                  <div class="col-12 col-md-9">
                                                    <?php 
                                                      echo $row_contrato['endereco_cc'].", ".$row_contrato['numero_cc'];
                                                      if(!empty($row_contrato['complemento_cc'])){
                                                        echo " - ".$row_contrato['complemento_cc'];
                                                      }else{

                                                      };
                                                      echo " - ".$row_contrato['bairro_cc'];
                                                    ?>
                                                  </div>
                                                </div>   
                                                 <div class="row form-group">
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>Produtor:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php 
                                                        echo $row_contrato['nome_completo_func'];
                                                    ?>
                                                  </div>
                                                   <div class="col col-md-3"><label class=" form-control-label"><b>Material:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php 
                                                        echo $row_contrato['material_cc'];
                                                    ?>
                                                  </div>
                                                </div> 
                                                 <div class="row form-group">
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>Valor do Material:</b></label></div>
                                                  <div class="col-12 col-md-3">
                                                    <?php 
                                                        echo "R$".number_format($row_contrato['valor_material_cc'], 2, ',', '.');
                                                    ?>
                                                  </div>
                                                  <div class="col col-md-3"><label class=" form-control-label"><b>% de Pagamento:</b></label></div>
                                                    <div class="col-12 col-md-3">
                                                      <?php 
                                                          $totalpago = 0;
                                                          if($unidadefunc == 1){
                                                            $select_total_pago = "SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento = '$ncontrato' AND status = '1'";
                                                          $exec_total_pago = mysqli_query($conn, $select_total_pago);
                                                          }else if($unidadefunc == 4){
                                                          $select_total_pago = "SELECT * FROM lancamento_concept WHERE n_contrato_lancamento = '$ncontrato' AND status = '1'";
                                                          $exec_total_pago = mysqli_query($conn, $select_total_pago);
                                                          };
                                                          while($row_financeiro = mysqli_fetch_assoc($exec_total_pago)){
                                                            if($row_financeiro['status_lancamento'] == 2){
                                                              $totalpago = $totalpago + $row_financeiro['valor_lancamento'];
                                                            };
                                                          };
                                                          $porcentagem = ($totalpago * 100) / $row_contrato['valor_material_cc'];

                                                          echo $porcentagem."%"; 
                                                      ?>
                                                    </div>
                                                  </div>
                                            </div>
                                          
                                            <div class="tab-pane fade" id="custom-nav-material" role="tabpanel" aria-labelledby="custom-nav-material-tab">
                                                <div class="row form-group">
                                                    <div class="col col-md-12"><label class=" form-control-label"><b><center><h3>Informações de Material</h3></center></b></label></div>
                                                  </div>
                                                  <div class="row form-group">
                                                    <div class="col col-md-3"><label class=" form-control-label"><b>Enviado Análise:</b></label></div>
                                                    <div class="col-12 col-md-9">
                                                      <?php 
                                                          if(!empty($row_contrato['data_enviado_analise'])){
                                                            echo date('d/m/Y H:i', strtotime($row_contrato['data_enviado_analise']));
                                                          }else{
                                                            echo "Aguardando";
                                                          };
                                                      ?>
                                                    </div>
                                                    <div class="col col-md-3"><label class=" form-control-label"><b>Liberado Edição:</b></label></div>
                                                    <div class="col-12 col-md-9">
                                                      <?php 
                                                          if(!empty($row_contrato['liberado_edicao'])){
                                                            echo date('d/m/Y H:i', strtotime($row_contrato['liberado_edicao']));
                                                          }else{
                                                            echo "Aguardando";
                                                          };
                                                      ?>
                                                    </div>
                                                    <div class="col col-md-3"><label class=" form-control-label"><b>Editado:</b></label></div>
                                                    <div class="col-12 col-md-9">
                                                      <?php 
                                                          if(!empty($row_contrato['editado_cc'])){
                                                            echo date('d/m/Y H:i', strtotime($row_contrato['editado_cc']));
                                                          }else{
                                                            echo "Aguardando";
                                                          };
                                                      ?>
                                                    </div>
                                                    <div class="col col-md-3"><label class=" form-control-label"><b>Na Gráfica:</b></label></div>
                                                    <div class="col-12 col-md-9">
                                                      <?php 
                                                          if(!empty($row_contrato['em_grafica_cc'])){
                                                            echo date('d/m/Y H:i', strtotime($row_contrato['em_grafica_cc']));
                                                          }else{
                                                            echo "Aguardando";
                                                          };
                                                      ?>
                                                    </div>
                                                    <div class="col col-md-3"><label class=" form-control-label"><b>Na Agência:</b></label></div>
                                                    <div class="col-12 col-md-9">
                                                      <?php 
                                                          if(!empty($row_contrato['na_agencia_cc'])){
                                                            echo date('d/m/Y H:i', strtotime($row_contrato['na_agencia_cc']));
                                                          }else{
                                                            echo "Aguardando";
                                                          };
                                                      ?>
                                                    </div>
                                                  </div> 
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-embolso" role="tabpanel" aria-labelledby="custom-nav-embolso-tab">
                                                <div class="row form-group">
                                                  <div class="col col-md-12"><label class=" form-control-label"><b><center><h3>Informações de Embolso</h3></center></b></label></div>
                                                </div>
                                                <div class="row form-group">
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Data Baixa</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Forma</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Valor</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Data Agrado</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Status</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Created</b></label></div>
                                                  <?php
                                                      while($row_lancamento = mysqli_fetch_assoc($exec_select_lancamento)){
                                                  ?>
                                                  <div class="col-12 col-md-2">
                                                    <?php
                                                      if(!empty($row_lancamento['data_baixa_lancamento'])){ 
                                                        echo date('d/m/Y', strtotime($row_lancamento['data_baixa_lancamento']));
                                                        }else{
                                                          echo "--";
                                                        }
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php 
                                                        echo $row_lancamento['descricao_tp']; 
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php 
                                                        echo "R$".number_format($row_lancamento['valor_lancamento'], 2, ',', '.');
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php 
                                                       if(!empty($row_lancamento['data_agrado_lancamento'])){
                                                          echo date('d/m/Y', strtotime($row_lancamento['data_agrado_lancamento']));
                                                       }else{
                                                          echo "--";
                                                       } 
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php 
                                                        echo $row_lancamento['descricao_status_lancamento']; 
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php 
                                                        echo date('d/m/Y', strtotime($row_lancamento['created_lancamento']));
                                                    ?>
                                                  </div>
                                                  <?php
                                                    };
                                                  ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-ts" role="tabpanel" aria-labelledby="custom-nav-ts-tab">
                                                <div class="row form-group">
                                                  <div class="col col-md-12"><label class=" form-control-label"><b><center><h3>Trabalhos e Seleções</h3></center></b></label></div>
                                                </div>
                                                 <div class="row form-group">
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Tipo</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Cachê</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Marca</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Data</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Hora</b></label></div>
                                                  <div class="col col-md-2"><label class=" form-control-label"><b>Status</b></label></div>
                                                  <?php
                                                      foreach($rowTs as $listarTs){
                                                  ?>
                                                  <div class="col-12 col-md-2"> 
                                                    <?php
                                                      if($listarTs->tipo == 1){
                                                        echo "Seleção";
                                                      }elseif($listarTs->tipo == 2){
                                                        echo "Trabalho";
                                                      };
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <a href="#" title="<?php echo "R$".number_format($rowTs->valor_cache, 2, ',', '.'); ?>">
                                                    <?php
                                                      if($listarTs->tipo_cache == 1){
                                                        echo "Pagar";
                                                      }elseif($listarTs->tipo_cache == 2){
                                                        echo "Receber";
                                                      }else{
                                                        echo "--";
                                                      }
                                                    ?>
                                                  </a>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php
                                                      echo $listarTs->descricao_marcas;
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php
                                                      echo date('d/m/Y', strtotime($listarTs->data_marcada));
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php
                                                      echo date('H:m', strtotime($listarTs->hora_marcada));
                                                    ?>
                                                  </div>
                                                  <div class="col-12 col-md-2">
                                                    <?php
                                                      $data_atual = date("Y-m-d");
                                                      if($listarTs->data_marcada < $data_atual){
                                                        echo "Faltou";
                                                      }else{
                                                        if($listarTs->compareceu == 1){
                                                          echo "Compareceu";
                                                        }else{
                                                          echo "Aguardando ...";
                                                        }
                                                      }
                                                    ?>
                                                  </div>
                                                  <?php
                                                    };
                                                  ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-cursos" role="tabpanel" aria-labelledby="custom-nav-cursos-tab">
                                                <p>TELA 5</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>    


                          
                            
                          


                          

                      </div>
                    
                        </form>                       
                      </div>
                    </div>

        <!-- FIM DE FORM DE CADASTRO -->
       

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

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
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

<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>