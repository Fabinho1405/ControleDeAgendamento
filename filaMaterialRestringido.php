<?php
    session_start();
    if(!empty($_SESSION['id_usuario']) && $_SESSION['permissao'] != 1 && $_SESSION['menu_gerente_agencia'] == 1){
    //nclude_once("php/verificar_sessao.php");
    include_once("conection/conexao.php");
    include_once("conection/connection.php");
    $pdo=conectar();
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
                            <strong class="card-title">Fila</strong> de Materiais Finalizados.Porém Restringidos Para Edição <small>Selecione um para Liberar.</small>
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><center>Contrato</center></th>
                        <th><center>Nome Modelo</center></th>
                        <th><center>Nome Responsável</center></th>
                        <th><center>Data de Fechamento</center></th>
                        <th><center>Produtor</center></th>
                        <th><center>Material</center></th>
                        <th><center>Status</center></th>
                        <th><center>Valor do Contrato</center></th>
                        <th><center>Valor Pago</center></th>
                        <th><center>%</center></th>
                        <th><center>Interno</center></th>
                        <th><center>Lib.</center></th>
                        <th><center>Ação</center></th>
                      </tr>
                    </thead>                    
                        <?php  
                        
                        if($unidade == 4){
                            $select_fila_edicao = "SELECT * FROM clientes_concept WHERE status_cc = '1' ORDER BY liberado_edicao DESC";
                            $exec_select_edicao = mysqli_query($conn, $select_fila_edicao);
                            $qtd_resultado_fila = mysqli_num_rows($exec_select_edicao);
                        }else if($unidade == 1){

                           try{
                                //Verifica Contratos em Aberto
                                $contratosAbertos=$pdo->prepare("SELECT * FROM clientes_exclusive ce INNER JOIN status_contrato sc ON ce.status_cc = sc.id_sc INNER JOIN funcionario func ON ce.id_produtor = func.id_func WHERE ce.status_cc IN('2','3','4','5') ORDER BY ce.data_cadastro_cc ASC");
                                $contratosAbertos->execute();
                                $qtdContratosAbertos=$contratosAbertos->rowCount();
                                $linhaContratosAbertos=$contratosAbertos->fetchall(PDO::FETCH_OBJ); 

                            }catch(Exception $e){
                                echo $e->getMessage();
                            }
                        };
                        if($qtdContratosAbertos > 0){                            
                            foreach($linhaContratosAbertos as $rowContratos){
                                $nContrato=$rowContratos->contrato_cc;                  

                        ?>
                    <tbody>
                        <td><?php echo $rowContratos->contrato_cc; ?></td>
                        <td ><?php echo $rowContratos->nome_modelo_cc; ?></td>
                        <td ><?php echo $rowContratos->nome_responsavel_cc; ?></td>
                        <td ><?php echo date("d/m/Y", strtotime($rowContratos->data_cadastro_cc))?></td>
                        <td ><?php echo $rowContratos->nome_completo_func; ?></td>
                        <td ><?php echo $rowContratos->material_cc; ?></td>
                        <td ><?php echo $rowContratos->descricao_sc; ?></td>
                        <td ><?php echo "R$".number_format($rowContratos->valor_material_cc,2,',','.'); ?></td>
                <?php
                        //Verifica Valor Pago
                        try{
                            $valorPago=$pdo->prepare("SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento=:contrato AND status_lancamento=:statusLancamento AND status=:status");
                            $valorPago->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
                            $valorPago->bindValue(":statusLancamento", 2, PDO::PARAM_INT);
                            $valorPago->bindValue(":status", 1, PDO::PARAM_INT);
                            $valorPago->execute();
                            $linhaValorPago=$valorPago->fetchall(PDO::FETCH_OBJ);
                            $totalPago=0;
                            foreach($linhaValorPago as $rowPago){
                                $totalPago+=$rowPago->valor_lancamento;
                            };
                ?>
                            <td><?php echo "R$".number_format($totalPago,2,',','.'); ?></td>
                <?php
                        if($totalPago == 0){
                            $porcentagem=0;
                        }else{
                        $porcentagem = ($totalPago * 100) / $rowContratos->valor_material_cc;
                        }
                ?>

                            <td><?php 
                                if($porcentagem == 0){
                                    echo "0%";
                                }else{
                                echo round($porcentagem, 2)."%"; 
                                }

                            ?></td>
                            <td><?php if($totalPago > 0){echo "<font color='green'><b>  </b></font>";}else{echo "<font color='red'>GVT</font> ";} ?></td>
                            <td ><?php if($porcentagem >= 40){echo "<font color='green'><b>S</b></font>";}else{echo "<font color='red'>N</font> ";} ?></td>
                            <td><?php if($porcentagem >= 40){?><a href="actions/actLiberarMaterial.php?nContrato=<?php echo $nContrato; ?>">Liberar</a><?php }else{echo "<font color='red'>N</font> ";} ?></td>
                <?php
                        }catch(Exception $e){
                            echo $e->getMessage();
                        }
                ?>
                    </tbody>
                    <?php
                        };
                    
                    ?>
                  </table> 
                  <?php
                    }else{
                        echo "<center>Sem clientes nesse setor  :( </center>";
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
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>
