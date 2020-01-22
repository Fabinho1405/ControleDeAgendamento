<?php
    session_start();
    if(!empty($_SESSION['id_usuario']) && $_SESSION['permissao'] != 1 && $_SESSION['menu_gerencia'] == 1){
    include_once("conection/connection.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
    $pdo=conectar();
    $date_atual=date("Y-m-d");

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
            <?php
                $totalAgendados=$pdo->prepare("SELECT * FROM agendamentos WHERE id_unidade=:unidade AND date(data_cadastro_agendamento)=:dataAtual");
                $totalAgendados->bindValue(":unidade", $unidadefunc);
                $totalAgendados->bindValue(":dataAtual", $date_atual);
                $totalAgendados->execute();
                $qtdTotalAgendados=$totalAgendados->rowCount();
            ?>
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Detalhes</strong> em Tempo Real dos Agendamentos - TOTAL: <?php echo $qtdTotalAgendados; ?>
                        </div>
                        <div class="card-body card-block">
                            <?php
                                
                                $scouterUnidade=$pdo->prepare("SELECT * FROM funcionario WHERE id_unidade=:unidade AND menu_scouter_insta = 1 AND status_sistema = 1 OR id_unidade=:unidade AND menu_scouter_ligacao_new = 1 AND status_sistema = 1 OR id_unidade=:unidade AND menu_scouter_wts = 1 AND status_sistema = 1 OR id_unidade=:unidade AND menu_scouter_face = 1 ORDER BY nome_completo_func ASC");
                                $scouterUnidade->bindValue(":unidade", $unidadefunc);
                                $scouterUnidade->execute();
                                $linhaScouter=$scouterUnidade->fetchAll(PDO::FETCH_OBJ);
                                foreach($linhaScouter as $listarScouter){
                                    $idfunc=$listarScouter->id_func;

                                    $totalAgendamentos=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFunc AND date(data_cadastro_agendamento)=:dataAtual AND reagendado=:reagendado");
                                    $totalAgendamentos->bindValue(":idFunc", $idfunc);
                                    $totalAgendamentos->bindValue(":dataAtual", $date_atual);
                                    $totalAgendamentos->bindValue(":reagendado", 0);
                                    $totalAgendamentos->execute();
                                    $qtdTotalAgendamentos=$totalAgendamentos->rowCount();

                                    $totalReAgendamentos=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFunc AND date(data_cadastro_agendamento)=:dataAtual AND reagendado=:reagendado");
                                    $totalReAgendamentos->bindValue(":idFunc", $idfunc);
                                    $totalReAgendamentos->bindValue(":dataAtual", $date_atual);
                                    $totalReAgendamentos->bindValue(":reagendado", 1);
                                    $totalReAgendamentos->execute();
                                    $qtdTotalReAgendamentos=$totalReAgendamentos->rowCount();



                            ?>
                            <!-- INICIO DO CARD -->
                            <div class="col-md-4" style="#scouter.hover{font-size: 30px;}" id="scouter">
                                <div class="card border border-primary">
                                    <div class="card-header">
                                        <strong class="card-title"><?php echo $listarScouter->nome_completo_func; ?> <br> 
                                            <small>
                                                <?php 
                                                    $insta=0;
                                                    $liga=0;
                                                    $whats=0;
                                                    $face=0;
                                                    if($listarScouter->menu_scouter_insta == 1){
                                                        echo "-Instagram-";
                                                        $insta=1;
                                                    }else{

                                                    }
                                                    if($listarScouter->menu_scouter_ligacao_new == 1){
                                                        echo "-Ligação-";
                                                        $liga=1;
                                                    }else{

                                                    }
                                                    if($listarScouter->menu_scouter_wts == 1){
                                                        echo "-Whatsapp-";
                                                        $whats=1;
                                                    }else{

                                                    }
                                                    if($listarScouter->menu_scouter_face == 1){
                                                        echo "-Facebook-";
                                                        $face=1;
                                                    }else{

                                                    }
                                                ?>
                                            </small>
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            Total de Agendados: <?php echo $qtdTotalAgendamentos; ?>
                                            <br />
                                            Total de Reagendados: <?php echo $qtdTotalReAgendamentos; ?>
                                            <br />
                                            <?php
                                            if($liga == 1){
                                                $qtdFeedBack=$pdo->prepare("SELECT * FROM controle_fb_ligacao WHERE date(hora_ligacao) = :dataAtual AND id_func=:idFunc");
                                                $qtdFeedBack->bindValue(":dataAtual", $date_atual);
                                                $qtdFeedBack->bindValue(":idFunc", $idfunc);
                                                $qtdFeedBack->execute();
                                                $qtdTotalFeedBack=$qtdFeedBack->rowCount();
                                                echo "FeedBacks: ".$qtdTotalFeedBack."<br />";

                                                $qtdFichaLiberada=$pdo->prepare("SELECT * FROM controle_ligacao WHERE id_func=:idFunc AND date(data_liberada_stand_by)=:dataAtual");
                                                $qtdFichaLiberada->bindValue(":idFunc", $idfunc);
                                                $qtdFichaLiberada->bindValue(":dataAtual", $date_atual);
                                                $qtdFichaLiberada->execute();
                                                $qtdTotalFichaLiberada=$qtdFichaLiberada->rowCount();
                                                echo "Fichas Liberadas:".$qtdTotalFichaLiberada;

                                            }else{
                                                echo " -- <br />";
                                                echo " -- ";
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div> 
                            <!-- FIM DO CARD -->
                            <?php
                                };
                            ?>
                        </div>                     
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
