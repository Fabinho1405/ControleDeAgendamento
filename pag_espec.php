<?php
     session_start();

   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['aut_financeiro'] == 1){
    include_once("conection/conexao.php");
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
                        <strong>Cadastrar</strong> Promessa de Pagamento
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>

                    <?php
                    $ncontrato = $_GET['ctn'];
                    $metodo = $_POST['forma_pagamento'];
                      if($metodo == 1){
                        //METODO EM DINHEIRO

                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '1'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_dinheiro" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>
                    <?php
                      }else if($metodo == 2){
                        //METODO EM CHEQUE
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '2'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor do Cheque:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_cheque" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data de Agrado:</label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_agrado_cheque" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>
                    <?php
                      }else if($metodo == 3){
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '3'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Quantidade:</label></div>
                            <div class="col-12 col-md-9">
                              <select name="qtd_boleto" class="form-control">
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                              </select>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor Total do Boleto:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_boleto" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data do 1º Vencimento:</label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_agrado_boleto" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>

                    <?php
                      }else if($metodo == 4){
                    ?>
                       <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '4'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_debito" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>

                    <?php
                      }else if($metodo == 5){
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '5'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_credito" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>
                    <?php
                      }else if($metodo == 6){ 
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '6'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor do Depósito:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_deposito" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data de Agrado:</label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_agrado_deposito" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>
                    <?php
                      }else if($metodo == 7){
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_inserir_pagamento.php?ctn=<?php echo $ncontrato; ?>&metodo=<?php echo '7'; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contrato:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php echo $ncontrato; ?>" disabled="true"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor da Via:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_via_unica" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data de Agrado:</label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_agrado_via_unica" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Promessa
                        </button>
                        </form>
                      </div>
                    <?php
                      }else{
                        echo "Forma de Pagamento Não Encontrada!";
                      };
                    ?>
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

</body>
</html>
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    };
?>
