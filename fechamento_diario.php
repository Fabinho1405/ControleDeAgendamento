<?php
    session_start();
    if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_recepcao'] == 1){
    include_once("conection/connection.php");
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

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

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
        <div class="content mt-3">
            <div class="col-sm-12" >
                <div class="col-lg-6">
                    <div class="card" style="max-width: 900px; width: 800px;">
                      <div class="card-header" style="max-width: 900px; width: 800px;">
                        <strong>Detalhes</strong> do Dia
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>
                      <div class="card-body card-block">
                        <?php
                            date_default_timezone_set('America/Sao_Paulo');
                            try{
                              $pdo=conectar();
                              $date_atual = date('Y-m-d');
                              if($unidadefunc == 1){
                                $resumoDia=$pdo->prepare("SELECT * FROM clientes_exclusive cc INNER JOIN funcionario func ON cc.id_produtor = func.id_func WHERE date(cc.data_cadastro_cc)=:dataAtual");
                                $subidasDia=$pdo->prepare("SELECT * FROM agendamentos ag  WHERE date(ag.data_agendada_agendamento)=:dataAtual AND ag.id_unidade=:unidade AND ag.id_comparecimento=:comparecimento");
                                $lancamentosDia=$pdo->prepare("SELECT * FROM lancamento_exclusive lc INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.created_lancamento) = :dataAtual AND lc.status = :status");
                                $pagamentosDia=$pdo->prepare("SELECT * FROM lancamento_exclusive lc INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.data_baixa_lancamento) = :dataAtual AND lc.status = :status AND date(lc.data_baixa_lancamento) <> date(lc.created_lancamento)");
                                $despesasDia=$pdo->prepare("SELECT * FROM despesas_exclusive dc INNER JOIN funcionario func ON dc.func_despesa = func.id_func WHERE date(created_despesa) = :dataAtual");

                              }elseif($unidadefunc == 4){
                                $resumoDia=$pdo->prepare("SELECT * FROM clientes_concept cc INNER JOIN funcionario func ON cc.id_produtor = func.id_func WHERE date(cc.data_cadastro_cc)=:dataAtual");
                                $subidasDia=$pdo->prepare("SELECT * FROM agendamentos ag  WHERE date(ag.data_agendada_agendamento)=:dataAtual AND ag.id_unidade=:unidade AND ag.id_comparecimento=:comparecimento");
                                $lancamentosDia=$pdo->prepare("SELECT * FROM lancamento_concept lc INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.created_lancamento) = :dataAtual AND lc.status = :status");
                                $pagamentosDia=$pdo->prepare("SELECT * FROM lancamento_concept lc INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.data_baixa_lancamento) = :dataAtual AND lc.status = :status AND date(lc.data_baixa_lancamento) <> date(lc.created_lancamento)");
                                $despesasDia=$pdo->prepare("SELECT * FROM despesas_concept dc INNER JOIN funcionario func ON dc.func_despesa = func.id_func WHERE date(created_despesa) = :dataAtual");

                              }

                              $resumoDia->bindValue(":dataAtual", $date_atual);
                              $resumoDia->execute();
                              $qtdFechadosDia=$resumoDia->rowCount();

                              $subidasDia->bindValue(":dataAtual", $date_atual);
                              $subidasDia->bindValue(":unidade", $unidadefunc);
                              $subidasDia->bindValue(":comparecimento", 1);
                              $subidasDia->execute();
                              $qtdSubidasDia=$subidasDia->rowCount();

                              $lancamentosDia->bindValue(":dataAtual", $date_atual);
                              $lancamentosDia->bindValue(":status", 1);
                              $lancamentosDia->execute();

                              $pagamentosDia->bindValue(":dataAtual", $date_atual);
                              $pagamentosDia->bindValue(":status", 1);
                              $pagamentosDia->execute();

                              $despesasDia->bindValue(":dataAtual", $date_atual);
                              $despesasDia->execute();

                            }catch(PDOException $e){
                              $e->getMessage();  
                            }
                        ?>
                          <center><h3>Fechamento Diário</h3></center>                        
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Subidas:</label></div>
                            <div class="col-12 col-md-3"><?php echo $qtdSubidasDia; ?></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contratos Fechados:</label></div>
                            <div class="col-12 col-md-3"><?php echo $qtdFechadosDia; ?></div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Produtor</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Scouter</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor</label></div>
                            <?php
                              $linha = $resumoDia->fetchAll(PDO::FETCH_OBJ);
                              foreach($linha as $listar){
                            ?>
                            <div class="col-12 col-md-3"><?php echo $listar->contrato_cc; ?></div>
                            <div class="col-12 col-md-3"><?php echo $listar->nome_completo_func; ?></div>
                            <div class="col-12 col-md-3">00</div>
                            <div class="col-12 col-md-3"><?php echo "R$".number_format($listar->valor_material_cc,2,',','.'); ?></div>
                            <?php
                              }
                            ?>
                          </div> 

                          <center> <h4> Lançamentos do Dia </h4> </center> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Forma de Pgto.</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Status</label></div>
                            <?php
                              $linhaLanc=$lancamentosDia->fetchAll(PDO::FETCH_OBJ);
                              $totalLanc=0;
                              $totalLancCVC=0;
                              foreach($linhaLanc as $listarLanc){
                                $totalLanc = $totalLanc + $listarLanc->valor_lancamento;
                                if($listarLanc->status_lancamento == 2 && $listarLanc->status == 1){
                                  $totalLancCVC = $totalLancCVC + $listarLanc->valor_lancamento;
                                }
                            ?>
                            <div class="col-12 col-md-3"><?php echo $listarLanc->n_contrato_lancamento; ?></div>
                            <div class="col-12 col-md-3"><?php echo $listarLanc->descricao_tp; ?></div>
                            <div class="col-12 col-md-3"><?php echo "R$".number_format($listarLanc->valor_lancamento,2,',','.'); ?></div>
                            <div class="col-12 col-md-3"><?php echo $listarLanc->descricao_status_lancamento; ?></div>
                            <?php
                              }
                            ?>
                            <div class="col-12 col-md-3"><?php echo "Total Dia: R$".number_format($totalLanc,2,',','.');  ?></div>
                            <div class="col-12 col-md-3"> -- </div>
                            <div class="col-12 col-md-3"><?php echo "Total CVC: R$".number_format($totalLancCVC,2,',','.');; ?></div>
                            <div class="col-12 col-md-3"> -- </div>
                          </div>
                          <!-- INICIA PAGAMENTOS DO DIA --> 
                          <hr>
                          <center> <h4> Baixas do Dia </h4> </center> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Forma de Pgto.</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Status</label></div>
                            <?php
                              $linhaPag=$pagamentosDia->fetchAll(PDO::FETCH_OBJ);
                              $totalPag=0;
                              foreach($linhaPag as $listarPag){
                                if($listarPag->tipo_pagamento_lancamento <> 7){
                                $totalPag = $totalPag + $listarPag->valor_lancamento;
                              }
                            ?>
                            <div class="col-12 col-md-3"><?php echo $listarPag->n_contrato_lancamento; ?></div>
                            <div class="col-12 col-md-3"><?php echo $listarPag->descricao_tp; ?></div>
                            <div class="col-12 col-md-3"><?php echo "R$".number_format($listarPag->valor_lancamento,2,',','.'); ?></div>
                            <div class="col-12 col-md-3"><?php echo $listarPag->descricao_status_lancamento; ?></div>
                            <?php
                              }
                            ?>
                            <div class="col-12 col-md-3"><?php echo "Total Dia: R$".number_format($totalPag,2,',','.');  ?></div>
                            <div class="col-12 col-md-3"> -- </div>
                            <div class="col-12 col-md-3"> -- </div>
                            <div class="col-12 col-md-3"> -- </div>
                          </div> 
                          <!-- INICIA DESPESAS -->
                          <hr>
                          <center> <h4> Despesas do Dia </h4> </center> 
                          <div class="row form-group">
                            <?php
                              if($despesasDia->rowCount() == 0){ 
                            ?>
                              <div class="col col-md-12"><label for="text-input" class=" form-control-label"><center>Nenhuma Despesa Encontrada</center></label></div>
                            <?php

                              }else{

                              ?>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">ID</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Descrição</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor</label></div>
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Funcionário</label></div>
                            <?php     
                              $linhaDes=$despesasDia->fetchAll(PDO::FETCH_OBJ);                         
                              foreach($linhaDes as $listarDes){
                            ?>
                            <div class="col-12 col-md-3"><?php echo $listarDes->id_despesas; ?></div>
                            <div class="col-12 col-md-3"><?php echo $listarDes->descricao_despesa; ?></div>
                            <div class="col-12 col-md-3"><?php echo "R$".number_format($listarDes->valor_despesa,2,',','.'); ?></div>
                            <div class="col-12 col-md-3"><?php echo $listarDes->nome_completo_func; ?></div>
                            <?php
                              }
                            ?>
                            <?php
                              }
                            ?>
                          </div> 



                    </div>
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
        <?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>

</body>
</html>
