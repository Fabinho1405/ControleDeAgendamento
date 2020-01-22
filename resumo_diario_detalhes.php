<?php
    session_start();
    if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1){
    include_once("conection/connection.php");  
    include_once("conection/conexao.php");

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
                        <strong>Detalhes</strong> de Resumo Diário
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                        $date = $_GET['dataresumo'];
                        $unidade = $_GET['select_unidade'];

                            $pesquisa_resumo = "SELECT * FROM `agendamentos` WHERE `data_agendada_agendamento`= '$date' AND `id_unidade` = '$unidade' AND reagendado = '0'";
                          $pesquisa_resumo_query = mysqli_query($conn, $pesquisa_resumo);
                          $cont_pesquisa_resumo = mysqli_num_rows($pesquisa_resumo_query);

                          $pesquisa_resumo_reagendado = "SELECT * FROM `agendamentos` WHERE `data_agendada_agendamento`= '$date' AND `id_unidade` = '$unidade' AND reagendado = '1'";
                          $pesquisa_resumo_reagendado_query = mysqli_query($conn, $pesquisa_resumo_reagendado);
                          $cont_pesquisa_reagendado = mysqli_num_rows($pesquisa_resumo_reagendado_query);

                          $pesquisa_resumo_confirmados = "SELECT * FROM `agendamentos` WHERE `data_agendada_agendamento`= '$date' AND `id_unidade` = '$unidade' AND confirmado = '1'";
                          $pesquisa_resumo_confirmados_query = mysqli_query($conn, $pesquisa_resumo_confirmados);
                          $cont_pesquisa_confirmados = mysqli_num_rows($pesquisa_resumo_confirmados_query);

                        if($cont_pesquisa_resumo <> 0){                     
                        $soma_total = $cont_pesquisa_resumo + $cont_pesquisa_reagendado;                

                    ?>
                      <div class="card-body card-block">                        
                          <div class="row form-group">
                            <div class="col col-md-5"><label for="text-input" class=" form-control-label">Quantidade de Agendados:</label></div>
                            <div class="col-12 col-md-9"><?php echo $cont_pesquisa_resumo; ?></div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-5"><label for="text-input" class=" form-control-label">Quantidade de Re-Agendados:</label></div>
                            <div class="col-12 col-md-9"><?php echo $cont_pesquisa_reagendado; ?></div>
                          </div>          
                          <div class="row form-group">
                            <div class="col col-md-5"><label for="text-input" class=" form-control-label">Confirmados:</label></div>
                            <div class="col-12 col-md-9"><?php echo $cont_pesquisa_confirmados; ?></div>
                          </div>    
                          <div class="row form-group">
                            <div class="col col-md-5"><label for="text-input" class=" form-control-label">Previsão de Comparecimento:</label></div>
                            <div class="col-12 col-md-9"><?php echo $soma_total; ?></div>
                          </div> 
                          <?php
                            }else{
                            echo "<center> Nenhum Agendamento :( </center>";
                          };
                           ?>
                      <div class="card-footer">
                        
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
