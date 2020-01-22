<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_recepcao'] == 1){
    include_once("conection/conexao.php");
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
                            <strong class="card-title">Impressões</strong> Disponíveis a Esse Cliente
                        </div>
                        <div class="card-body">
                            <center>
                            <br>
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Autorização de Imagem</th>
                      </tr>
                    </thead>
                    <tbody>                  
                                    <tr>
                                        <td>
                                            <?php
                                                if($unidadefunc == 4){
                                                    $contrato = $_GET['cnt'];
                                                    $select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$contrato'";
                                                    $exec_select_contrato = mysqli_query($conn, $select_contrato);
                                                    $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

                                                    $valor_total_contrato = $row_contrato['valor_material_cc'];
                                                    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_concept WHERE n_contrato_lancamento = '$contrato' AND status_lancamento <> 3";
                                                    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
                                                    $final_aberto = 0;
                                                    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
                                                        $valor_atual = $row_pagamento['valor_lancamento'];
                                                        $final_aberto = $final_aberto + $valor_atual;
                                                    }
                                                    $final_aberto_pag = $valor_total_contrato - $final_aberto;

                                                    if($final_aberto_pag < 1){
                                                    echo "<a href='relatorios/contrato_concept.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='48px' height='48px'></a>";
                                                    }else{
                                                        echo "Complete as Informacoes Financeiras";
                                                    };
                                                }else if($unidadefunc == 1){
                                                    $contrato = $_GET['cnt'];
                                                    $select_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$contrato'";
                                                    $exec_select_contrato = mysqli_query($conn, $select_contrato);
                                                    $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

                                                    $valor_total_contrato = $row_contrato['valor_material_cc'];
                                                    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_exclusive WHERE n_contrato_lancamento = '$contrato' AND status_lancamento <> 3";
                                                    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
                                                    $final_aberto = 0;
                                                    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
                                                        $valor_atual = $row_pagamento['valor_lancamento'];
                                                        $final_aberto = $final_aberto + $valor_atual;
                                                    }
                                                    $final_aberto_pag = $valor_total_contrato - $final_aberto;

                                                    if($final_aberto_pag < 1){
                                                    echo "<a href='relatorios/contrato_exclusive.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='48px' height='48px'></a>";
                                                    }else{
                                                        echo "Complete as Informacoes Financeiras";
                                                    };
                                                };
                                            ?>
                                        </td>                                                    
                                        <td>
                                        <?php  
                                        if($unidadefunc == 4){
                                        $idcliente = $row_parametro['contrato_cc'];
                                        echo "<a href='relatorios/termo_imagem_concept.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='48px' height='48px' ></a>";
                                        }else if($unidadefunc == 1){
                                        $idcliente = $row_parametro['contrato_cc'];
                                        echo "<a href='relatorios/termo_imagem_exclusive.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='48px' height='48px' ></a>";
                                        };
                                        ?></td>
                                    </tr>                                 
                      
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