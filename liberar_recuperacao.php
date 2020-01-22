<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_gerencia'] == 1){
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

                        <!-- PUXAR RECUPERAÇÃO -->
                      <div class="card-header" style="max-width: 900px; width: 800px;">
                        <strong>Controle</strong> de Recuperação de Ficha Para Colaborador
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_puxar_ficha.php" method="post" enctype="multipart/form-data" class="form-horizontal" name="puxa">
                            <div class="row form-group">
                            <div class="col col-md-12"><center><b><h3>Puxar Fichas</h3></b></center></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Especificações:</label></div>
                            <div class="col-12 col-md-9">
                                <?php

                                    $select_func_lig = "SELECT * FROM funcionario WHERE id_unidade = '$unidadefunc' AND menu_scouter_ligacao_new = '1'";
                                    $exec_func_lig = mysqli_query($conn, $select_func_lig);
                                    $total_recuperacao = 0;
                                    while($row_func = mysqli_fetch_assoc($exec_func_lig)){
                                        $id_func_query = $row_func['id_func'];
                                    $select_quantidade = "SELECT * FROM controle_ligacao WHERE id_func = '$id_func_query' AND id_status_sistema = '1' AND id_extracao = '0' AND liberado_controle_externo = '0' AND id_procedimento > '50001' AND unid_stand_by = '$unidadefunc' AND date(data_liberada_stand_by) <> date(NOW()) ORDER BY qtd_feedback ASC";
                                    $exec_quantidade = mysqli_query($conn, $select_quantidade);
                                    $qtd_recuperacao = mysqli_num_rows($exec_quantidade);
                                    echo $row_func['nome_completo_func']." - ".$qtd_recuperacao."<br>";
                                    $total_recuperacao = $total_recuperacao + $qtd_recuperacao;
                                };
                                ?>
                            </div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Totais de Recuperação:</label></div>
                            <div class="col-12 col-md-9">
                                <?php
                                    echo $total_recuperacao;
                                ?>
                            </div>
                          </div>                        
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Colaborador:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="idcolaborador" class="form-control">
                                <?php
                                    $pesquisar_funcionario = "SELECT * FROM funcionario WHERE menu_scouter_ligacao_new = '1' AND id_unidade = '$unidadefunc'";
                                    $exec_pesquisa_funcionario = mysqli_query($conn, $pesquisar_funcionario);
                                    while($row_funcionario = mysqli_fetch_assoc($exec_pesquisa_funcionario)){
                                ?>
                                    <option value="<?php echo $row_funcionario['id_func']; ?>"> 
                                        <?php echo $row_funcionario['nome_completo_func']; ?>               
                                    </option>
                                <?php
                                    };
                                ?>

                                </select>
                            </div>
                          </div>
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Quantidade:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="qtd_fichas" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-12"> <center><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> Puxar Fichas </button></center>
                            </div>
                        </div>
                         </form>  

                         <!-- INICIA LIBERAÇÃO DE FICHA -->
                          <form action="actions/act_liberar_ficha_pausada.php" method="post" enctype="multipart/form-data" class="form-horizontal" name="libera">
                            <div class="row form-group">
                            <div class="col col-md-12"><center><b><h3>Liberar Fichas</h3></b></center></div>
                          </div>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Totais Paradas:</label></div>
                            <div class="col-12 col-md-9">
                                <?php
                                    $select_quantidade = "SELECT * FROM controle_ligacao WHERE id_func = '1' AND id_status_sistema = '1' AND id_extracao = '0' AND liberado_controle_externo = '0' AND id_procedimento > '50001' AND unid_stand_by = '$unidadefunc' AND date(data_liberada_stand_by) <> date(NOW()) ORDER BY qtd_feedback ASC"; 
                                    $exec_quantidade = mysqli_query($conn, $select_quantidade);
                                    $qtd_recuperacao = mysqli_num_rows($exec_quantidade);
                                    echo $qtd_recuperacao;
                                ?>
                            </div>
                          </div>                         
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Colaborador:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="idcolaborador" class="form-control">
                                <?php
                                    $pesquisar_funcionario = "SELECT * FROM funcionario WHERE menu_scouter_ligacao_new = '1' AND id_unidade = '$unidadefunc'";
                                    $exec_pesquisa_funcionario = mysqli_query($conn, $pesquisar_funcionario);
                                    while($row_funcionario = mysqli_fetch_assoc($exec_pesquisa_funcionario)){
                                ?>
                                    <option value="<?php echo $row_funcionario['id_func']; ?>"> 
                                        <?php echo $row_funcionario['nome_completo_func']; ?>               
                                    </option>
                                <?php
                                    };
                                ?>

                                </select>
                            </div>
                          </div>
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Quantidade:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="qtd_fichas" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-12"><center> <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> Liberar Ficha </button></center>
                        </div>
                         </form>                            


                         <!-- FIM LIBERAÇÃO FICHA -->
                          </div>                     
                        
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
