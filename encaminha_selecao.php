<?php
    session_start();
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
                        <strong>Encaminhamento </strong> de Modelo para Seleções
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>
                      <div class="card-body card-block"> 
                        <form action="actions/act_cadastrar_ts.php?tp=1" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                            <div class="col-12 col-md-12">Olá Produtor! <br> Encaminhe os seus modelos para nossas marcas parceiras!.</div>
                          </div>  
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Número de Contrato:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="contrato_ts" class="form-control">
                                <?php
                                    $contratoget = $_GET['cnt'];
                                    if($idunidade == 1){
                                        if($_SESSION['menu_recepcao'] == 1){
                                            if(!empty($contratoget)){
                                            $pesquisar_contratos = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$contratoget' ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                            }else{
                                            $pesquisar_contratos = "SELECT * FROM clientes_exclusive ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                            };                                        
                                        }else{

                                            if(!empty($contratoget)){
                                            $pesquisar_contratos = "SELECT * FROM clientes_exclusive WHERE id_produtor = '$idfuncionario' AND contrato_cc = '$contratoget' ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                            }else{
                                            $pesquisar_contratos = "SELECT * FROM clientes_exclusive WHERE id_produtor = '$idfuncionario' ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                        }
                                        }


                                    }else if($idunidade == 4){
                                        if($_SESSION['menu_recepcao'] == 1){
                                            if(!empty($contratoget)){
                                            $pesquisar_contratos = "SELECT * FROM clientes_concept WHERE contrato_cc = '$contratoget' ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                            }else{
                                            $pesquisar_contratos = "SELECT * FROM clientes_concept ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                            };                                        
                                        }else{

                                            if(!empty($contratoget)){
                                            $pesquisar_contratos = "SELECT * FROM clientes_concept WHERE id_produtor = '$idfuncionario' AND contrato_cc = '$contratoget' ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                            }else{
                                            $pesquisar_contratos = "SELECT * FROM clientes_concept WHERE id_produtor = '$idfuncionario' ORDER BY contrato_cc DESC";
                                            $exec_pesquisar_contratos = mysqli_query($conn, $pesquisar_contratos);
                                        }
                                        }
                                    }                                                                        
                                        while($row_contratos = mysqli_fetch_assoc($exec_pesquisar_contratos)){
                                ?>
                                    <option value="<?php echo $row_contratos['contrato_cc']; ?>"> 
                                        <?php echo $row_contratos['contrato_cc']." - ".$row_contratos['nome_modelo_cc']; ?>             
                                    </option>
                                <?php
                                        };
                                ?>

                                </select>
                            </div>
                          </div>  
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Selecione a Marca:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="marca_ts" class="form-control">
                                <?php
                                    $pesquisar_funcionarios = "SELECT * FROM marcas WHERE selecao = '1' ORDER BY descricao_marcas ASC";
                                    $pesquisar_lista_funcionario = mysqli_query($conn, $pesquisar_funcionarios);
                                    while($row_funcionario = mysqli_fetch_assoc($pesquisar_lista_funcionario)){
                                ?>
                                    <option value="<?php echo $row_funcionario['id_marcas']; ?>"> 
                                        <?php echo $row_funcionario['descricao_marcas']; ?>               
                                    </option>
                                <?php
                                    };
                                ?>

                                </select>
                            </div>
                          </div> 

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data de agendamento:<b><font color="red">*</font></b> </label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_ts" placeholder="" class="form-control"><small class="form-text text-muted"></small></div>
                          </div>                               
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Hora agendada:<b><font color="red">*</font></b> </label></div>
                            <div class="col-12 col-md-9"><input type="time" id="text-input" name="hora_ts" placeholder="" class="form-control"><small class="form-text text-muted"></small></div>
                          </div>                 
                        
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Encaminhar
                        </button>
                        </form>
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

</body>
</html>
