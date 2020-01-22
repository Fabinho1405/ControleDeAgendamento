<?php
    session_start();
    include_once("conection/conexao.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];

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
                            <strong class="card-title">Materiais</strong> que já estão ja agência. &nbsp;&nbsp;&nbsp; <small>Selecione um para alterar o status.</small>
                        </div>
                        <div class="card-body">
                             <?php
                        if(isset($_SESSION['msgSetor'])){
                            echo $_SESSION['msgSetor'];
                            unset($_SESSION['msgSetor']);
                        };
                    ?>
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Nome</th>
                        <th>Responsável</th>
                        <th>Material</th>
                        <th>Dia Editado</th>
                        <th>Ação</th>
                      </tr>
                    </thead>                    
                        <?php  
                        
                        if($unidade == 4){
                            $select_fila_edicao = "SELECT * FROM clientes_concept WHERE status_cc = '10'";
                            $exec_select_edicao = mysqli_query($conn, $select_fila_edicao);
                            $qtd_resultado_fila = mysqli_num_rows($exec_select_edicao);                            
                        }else if($unidade == 1){
                            $select_fila_edicao = "SELECT * FROM clientes_exclusive WHERE status_cc = '10'";
                            $exec_select_edicao = mysqli_query($conn, $select_fila_edicao);
                            $qtd_resultado_fila = mysqli_num_rows($exec_select_edicao);
                        };
                        if($qtd_resultado_fila > 0){
                            while($row_fila = mysqli_fetch_assoc($exec_select_edicao)){                     

                        ?>
                    <tbody>
                      <tr>
                        <td><?php  echo $row_fila['contrato_cc']; ?></td>
                        <td><?php  echo $row_fila['nome_modelo_cc']; ?></td>
                        <td><?php  echo $row_fila['nome_responsavel_cc']; ?></td>
                        <td><?php  echo $row_fila['material_cc'];?></td>  
                        <td><?php echo date('d/m/Y', strtotime($row_fila['editado_cc']));  ?></td>
                        <td><?php  
                        $contrato = $row_fila['contrato_cc'];
                        echo "<a href='actions/actDenominarSetor.php?ncontrato={$row_fila['contrato_cc']}'>Denominar Setor </a>" 
                        ?></td>
                      </tr>
                    </tbody>
                    <?php
                        };
                    
                    ?>
                  </table> 
                  <?php
                    }else{
                        echo "<center>Sem clientes nesse setor :( </center>";
                    };
                  ?>                 
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
