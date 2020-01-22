<?php
    session_start();
    include_once("conection/conexao.php");
    $idfuncionario = $_SESSION['id_usuario'];
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
                            <strong class="card-title">Procurar Cliente</strong>
                        </div>
                        <div class="card-body">
                            <center>
                        <form method="POST" action="" name="form_pesquisacliente">                           
                            <label>Filtrar Por:</label>
                            <input type="radio" name="filtrocliente" value="1">Nome
                            <input type="radio" name="filtrocliente" value="2">Telefone  
                            <br>
                            <label>Parâmetro:</label>
                            <input type="text" name="parametro">
                            <br>
                            <input type="submit" name="pesquisarcliente">                            
                        </form>
                    </center>
                        <br>
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Telefone 2 </th>
                        <th>Responsável</th>
                        <th>Agendar !</th>
                      </tr>
                    </thead>                    
                        <?php  
                        $gatilhocliente = $_POST['pesquisarcliente'];
                         $filtro = $_POST['filtrocliente'];
                        $parametro = $_POST['parametro'];                        
                        if($_POST['pesquisarcliente']){
                            $result_usuarios = "SELECT * FROM cliente WHERE id_func = $idfuncionario ORDER BY id_cliente DESC LIMIT $inicio, $qnt_result_pg  ";
                            $resultado_usuarios = mysqli_query($conn, $result_usuarios);  
                            while($row_usuario = mysqli_fetch_assoc($resultado_usuarios)){
                        ?>
                    <tbody>
                      <tr>
                        <td><?php  echo $row_usuario['id_cliente']; ?></td>
                        <td><?php  echo $row_usuario['nome_cliente']; ?></td>
                        <td><?php  echo $row_usuario['telefone_cliente']; ?></td>
                        <td><?php  echo $row_usuario['telefone2_cliente']; ?></td>
                        <td><?php  echo $row_usuario['nome_responsavel_cliente']; ?></td>                       
                        <td><?php  echo "<a href='reagendar_cliente.php?id=" .$row_usuario['id_cliente']. "'><center><img src='images/agendar.png' width='32px' height='32px'></center></a>"; ?> </td>
                      </tr>
                    </tbody>
                    <?php
                        }
                    }else{

                        if($filtro == 1){
                            header("Location:google.com.br");
                        }else if($filtro == 2){
                            header("Location:facebook.com.br");
                        }

                    }
                    ?>
                  </table>
                  <?php
                    

                    //Paginção - Somar a quantidade de usuários
        $result_pg = "SELECT COUNT(id_cliente) AS num_result FROM cliente WHERE id_func = $idfuncionario";
        $resultado_pg = mysqli_query($conn, $result_pg);
        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //echo $row_pg['num_result'];
        //Quantidade de pagina 
        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
        
        //Limitar os link antes depois
        $max_links = 10;
        echo "<a href='pesquisar_cliente.php?pagina=1'>Primeira</a> ";
        
        for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
            if($pag_ant >= 1){
                echo "<a href='pesquisar_cliente.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        }
            
        echo "$pagina ";
        
        for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
            if($pag_dep <= $quantidade_pg){
                echo "<a href='pesquisar_cliente.php?pagina=$pag_dep'>$pag_dep</a> ";
            }
        }
        
        echo "<a href='pesquisar_cliente.php?pagina=$quantidade_pg'>Ultima</a>";


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
