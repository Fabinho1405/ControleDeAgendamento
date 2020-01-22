<?php
    session_start();

   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_auditoria'] == 1){
    include_once("conection/conexao.php");
    include_once("php/verificar_sessao.php");
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
                            <strong class="card-title">Últimos</strong> Agendamentos do Sistema
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>ID Ag.</th>
                        <th>Scouter</th>
                        <th>Unidade</th>
                        <th>Réplica</th>
                        <th>Qtd. Retorno</th>
                        <th>Data Enviado</th>
                        <th>Ações</th>
                        
                      </tr>
                    </thead> 
                    <?php 
                          $result_agendamento = "SELECT * FROM agendamentos ag
                            INNER JOIN funcionario fun ON ag.id_func = fun.id_func
                            INNER JOIN unidade un ON ag.id_unidade = un.id_unidade
                            INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente
                            INNER JOIN conta_utilizada cu ON ag.id_conta_utilizada = cu.id_conta_utilizada
                            WHERE ag.id_status_auditoria = '4' ORDER BY ag.data_cadastro_agendamento ASC LIMIT $inicio, $qnt_result_pg ";
                            $resultado_agendamento = mysqli_query($conn, $result_agendamento);

                    ?>                       
                    <tbody>
                        <?php                            
                            while($row_agendamento = mysqli_fetch_assoc($resultado_agendamento)){
                        ?>
                      <tr>
                        <td><?php  echo $row_agendamento['id_agendamentos']; ?></td>
                        <td><?php  echo $row_agendamento['nome_completo_func']; ?></td>
                        <td><?php  echo $row_agendamento['desc_unidade']; ?></td>
                        <td><?php  echo $row_agendamento['motivo_reanalise_auditoria']; ?></td>
                        <td><?php  echo $row_agendamento['qtd_re_analise_auditoria']."º Vez"; ?></td>
                        <td><?php  echo $row_agendamento['data_cadastro_agendamento']; ?></td>
                        <td><center><?php  echo "<a href=actions/act_registra_log.php?idagdm=".$row_agendamento['id_agendamentos']."&acao=2><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center>
                        </td>                           
                      </tr>
                    </tbody>
                    <?php }; ?>
                  </table>

                


                  <?php
                    

                    //Paginção - Somar a quantidade de usuários
        $result_pg = "SELECT COUNT(id_agendamentos) AS num_result FROM agendamentos ag
                            INNER JOIN funcionario fun ON ag.id_func = fun.id_func
                            INNER JOIN unidade un ON ag.id_unidade = un.id_unidade
                            INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente
                            INNER JOIN conta_utilizada cu ON ag.id_conta_utilizada = cu.id_conta_utilizada
                            WHERE ag.id_status_auditoria = '4' ORDER BY ag.data_cadastro_agendamento ASC";
        $resultado_pg = mysqli_query($conn, $result_pg);
        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //echo $row_pg['num_result'];
        //Quantidade de pagina 
        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
        
        //Limitar os link antes depois
        $max_links = 10;
        echo "<a href='reanalisar_agendamento_scouter.php?pagina=1'>Primeira</a> ";
        
        for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
            if($pag_ant >= 1){
                echo "<a href='reanalisar_agendamento_scouter.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        }
            
        echo "$pagina ";
        
        for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
            if($pag_dep <= $quantidade_pg){
                echo "<a href='reanalisar_agendamento_scouter.php?pagina=$pag_dep'>$pag_dep</a> ";
            }
        }
        
        echo "<a href='reanalisar_agendamento_scouter.php?pagina=$quantidade_pg'>Ultima</a>";


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
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    };
?>
