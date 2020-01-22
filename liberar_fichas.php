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
                      <div class="card-header" style="max-width: 900px; width: 800px;">
                        <strong>Encaminhar</strong> Ficha Para Colaborador
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/act_liberar_fichas.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">  Stand By:</label></div>
                            <div class="col-12 col-md-9">
                                <?php
                                    $select_quantidade = "SELECT * FROM controle_ligacao WHERE stand_by = '1' AND unid_stand_by = '$unidadefunc'";
                                    $exec_quantidade = mysqli_query($conn, $select_quantidade);
                                    $qtd_stand_by = mysqli_num_rows($exec_quantidade);
                                    echo $qtd_stand_by;
                                ?>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tipo:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="tipoficha" class="form-control">
                                    <?php
                                        $select_adulto = "SELECT * FROM controle_ligacao WHERE stand_by = '1' AND unid_stand_by = '$unidadefunc' AND tipo_ficha = '1'";
                                        $exec_select_adulto = mysqli_query($conn, $select_adulto);
                                        $qtd_adulto = mysqli_num_rows($exec_select_adulto);

                                        $select_infantil = "SELECT * FROM controle_ligacao WHERE stand_by = '1' AND unid_stand_by = '$unidadefunc' AND tipo_ficha = '2'";
                                        $exec_select_infantil = mysqli_query($conn, $select_infantil);
                                        $qtd_infantil = mysqli_num_rows($exec_select_infantil);

                                        $select_mix = "SELECT * FROM controle_ligacao WHERE stand_by = '1' AND unid_stand_by = '$unidadefunc' AND tipo_ficha = '3'";
                                        $exec_select_mix = mysqli_query($conn, $select_mix);
                                        $qtd_mix = mysqli_num_rows($exec_select_mix);

                                    ?>
                                    <option value="1">Adulto - <?php echo $qtd_adulto; ?></option>
                                    <option value="2">Infantil - <?php echo $qtd_infantil; ?></option>
                                    <option value="3">Mix - <?php echo $qtd_mix; ?></option>                                    
                                </select>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Quantidade:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="qtd_fichas" placeholder="" class="form-control"><small class="form-text text-muted"> </small></div>
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
                        
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Liberar Fichas
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
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>
