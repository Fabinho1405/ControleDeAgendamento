<?php
    session_start();
    include_once("conection/connection.php");
    $pdo=conectar();


    $idfuncionario = $_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];


    if($unidade == 1){
    $resultEventos=$pdo->prepare("SELECT * FROM retorno_exclusive");
    $resultEventos->execute();
    $linhaEventos=$resultEventos->fetchAll(PDO::FETCH_OBJ);
    }elseif($unidade == 4){
        $resultEventos=$pdo->prepare("SELECT * FROM retorno_concept");
    $resultEventos->execute();
    $linhaEventos=$resultEventos->fetchAll(PDO::FETCH_OBJ);
    }

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

            <link href='css/fullcalendar.min.css' rel='stylesheet' />
            <link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
            <link href='css/personalizado.css' rel='stylesheet' />
            <script src='js/moment.min.js'></script>
            <script src='js/jquery.min.js'></script>
            <script src='js/fullcalendar.min.js'></script>
            <script src='locale/pt-br.js'></script>
       

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
        $qnt_result_pg = 15;
        //calcular o inicio visualização
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;  
            ?>   
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Calendário</strong> de Retornos.
                        </div>
                        <div class="card-body">  
                            <center>
                            <table border=0>
                                <tr>
                                    <td align="right"><font color="#DC143C" size="10px"> ♦ </font></td>
                                    <td align="left" style="width: 150px;"> Não Compareceu </td>
                                    <td align="right"> <font color="#87CEEB" size="10px"> ♦ </font> </td>
                                    <td align="left" style="width: 150px;"> Agendado </td>
                                    <td align="right"> <font color="#FFD700" size="10px"> ♦ </font> </td>
                                    <td align="left" style="width: 150px;"> Compareceu </td>
                                </tr>
                            </table>
                        </center>
                        <br>
                             <script>
                                $(document).ready(function() {
                                    $('#calendar').fullCalendar({
                                        header: {
                                            left: 'prev,next today',
                                            center: 'title',
                                            right: 'month,agendaWeek,agendaDay'
                                        },
                                        defaultDate: Date(),
                                        navLinks: true, // can click day/week names to navigate views
                                        editable: false,
                                        eventLimit: true, // allow "more" link when too many events
                                        events: [
                                            <?php
                                                    foreach($linhaEventos as $rowEventos){  
                                            ?>
                                                    {
                                                    id: '<?php echo "1"; ?>',
                                                    title: '<?php echo "Retorno - ".$rowEventos->contrato_cc; ?>',
                                                    start: '<?php echo $rowEventos->data_rt." ".$rowEventos->horario_rt; ?>',
                                                    end: '<?php echo $rowEventos->data_rt." ".$rowEventos->horario_rt; ?>',
                                                    color: '<?php 
                                                        $dataAtual = date("Y-m-d");
                                                        if($rowEventos->data_rt < $dataAtual && $rowEventos->compareceu_rt == 0){
                                                            echo "#DC143C";
                                                        }else{
                                                            if($rowEventos->compareceu_rt == 1){
                                                                echo "#FFD700";
                                                            }else{
                                                                echo "#87CEEB";
                                                            }
                                                        }
                                                    ?>',
                                                    },<?php
                                                }
                                            ?>
                                        ]
                                    });
                                });
                            </script>
                            <div id="calendar"></div>                             
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
