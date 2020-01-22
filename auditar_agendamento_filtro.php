<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_auditoria'] == 1){
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
                            <strong class="card-title">Pesquisar</strong> Agendamento de Auditoria
                        </div>
                        <div class="card-body">
                            <center>                               
                            <form action="" method="GET">

                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Scouter</label></div>
                                <div class="col-12 col-md-9">

                                  <select name="filtro_scouter" id="select" class="form-control">
                                    <option value="SP">Todos Scouter's Por Produção</option>
                                    <option value="SCLT">Todos Scouter's Via CLT</option>
                                    <?php 
                                        $result_scouters = "SELECT * FROM funcionario WHERE status_sistema = '1' ORDER BY nome_completo_func ASC"; 
                                        $resultado_scouters = mysqli_query($conn, $result_scouters);
                                        while($row_scouters = mysqli_fetch_assoc($resultado_scouters)){ 
                                    ?>
                                    <option value="<?php echo $row_scouters['id_func']; ?>"><?php echo $row_scouters['nome_completo_func'];  ?></option>
                                   <?php
                                        };
                                   ?>
                                  </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Período</label></div>
                                <div class="col-12 col-md-6">
                                  <select name="filtro_periodo" id="select" class="form-control">
                                    <option value="0">Todos os Períodos</option>
                                    <option value="1">Período Específico</option>
                                  </select>
                                </div>
                                <div class="col-12 col-md-3">
                                  <input type="date" name="data_inicial" class="form-control"> à <input type="date" name="data_final" class="form-control">
                                </div>
                            </div>
                                <input type="submit" value="Pesquisar Cliente" class="btn btn-primary" name="enviar">             
                            </form>
                            <br>
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Scouter</th>
                        <th>Unidade</th>
                        <th>Data Enviado</th>
                        <th>Situação</th>
                        <th>Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($_GET['enviar'])){
                        //Declara FORM
                        $filtro_scouter = $_GET['filtro_scouter'];
                        $filtro_periodo = $_GET['filtro_periodo']; 
                        
                        if($filtro_scouter == "SP"){
                            //PESQUISA POR SCOUTER'S DE PRODUÇÃO
                                $scouter_producao = "SELECT * FROM funcionario WHERE linha_producao = '1'";
                                $exec_scouter_producao = mysqli_query($conn, $scouter_producao);
                                while($row_scouter_prod = mysqli_fetch_assoc($exec_scouter_producao)){
                                    $idfunc = $row_scouter_prod['id_func'];
                                    if($filtro_periodo == 0){
                                        //PEGA TODOS OS PERÍODOS
                                        $select_auditoria = "SELECT * FROM agendamentos ag
                                        INNER JOIN funcionario func ON ag.id_func = func.id_func
                                        INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade
                                        WHERE ag.id_status_auditoria = '1' AND ag.id_func = '$idfunc' ORDER BY date(ag.data_cadastro_agendamento) ASC";
                                        $exec_select_auditoria = mysqli_query($conn, $select_auditoria);
                                        while($row_auditoria = mysqli_fetch_assoc($exec_select_auditoria)){
                    ?>
                                            <tr>
                                                <td><?php echo $row_auditoria['id_agendamentos']; ?></td>
                                                <td><?php echo $row_auditoria['nome_completo_func']; ?></td>
                                                <td><?php echo $row_auditoria['desc_unidade']; ?></td>
                                                <td><?php echo $row_auditoria['data_cadastro_agendamento']; ?></td>
                                                <td><?php echo $row_auditoria['reagendado']; ?></td>
                                                <td><center><?php  echo "<a href='actions/act_registra_log.php?idagdm=".$row_auditoria['id_agendamentos']."&acao=1' target = '_blank'><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center></td>
                                            </tr>
                    <?php

                                        };
                                    }else if($filtro_periodo == 1){
                                        //PEGA PERÍODO ESPECÍFICO
                                        $inicio = $_GET['data_inicial'];
                                        $final = $_GET['data_final'];
                                        $select_auditoria = "SELECT * FROM agendamentos ag
                                        INNER JOIN funcionario func ON ag.id_func = func.id_func
                                        INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade
                                        WHERE ag.id_status_auditoria = '1' AND ag.id_func = '$idfunc' AND date(ag.data_cadastro_agendamento) BETWEEN '$inicio' AND '$final' ORDER BY date(ag.data_cadastro_agendamento) ASC";
                                        $exec_select_auditoria = mysqli_query($conn, $select_auditoria);
                                        while($row_auditoria = mysqli_fetch_assoc($exec_select_auditoria)){
                    ?>
                                            <tr>
                                                <td><?php echo $row_auditoria['id_agendamentos']; ?></td>
                                                <td><?php echo $row_auditoria['nome_completo_func']; ?></td>
                                                <td><?php echo $row_auditoria['desc_unidade']; ?></td>
                                                <td><?php echo $row_auditoria['data_cadastro_agendamento']; ?></td>
                                                <td><?php echo $row_auditoria['reagendado']; ?></td>
                                                <td><center><?php  echo "<a href='actions/act_registra_log.php?idagdm=".$row_auditoria['id_agendamentos']."&acao=1' target = '_blank'><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center></td>
                                            </tr>
                    <?php

                                        };
                                    }
                                }
                        }else if($filtro_scouter == "SCLT"){
                           //PESQUISA POR SCOUTER'S DE CLT
                                $scouter_producao = "SELECT * FROM funcionario WHERE linha_producao = '0'";
                                $exec_scouter_producao = mysqli_query($conn, $scouter_producao);
                                while($row_scouter_prod = mysqli_fetch_assoc($exec_scouter_producao)){
                                    $idfunc = $row_scouter_prod['id_func'];
                                    if($filtro_periodo == 0){
                                        //PEGA TODOS OS PERÍODOS
                                        $select_auditoria = "SELECT * FROM agendamentos ag
                                        INNER JOIN funcionario func ON ag.id_func = func.id_func
                                        INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade
                                        WHERE ag.id_status_auditoria = '1' AND ag.id_func = '$idfunc' ORDER BY date(ag.data_cadastro_agendamento) ASC";
                                        $exec_select_auditoria = mysqli_query($conn, $select_auditoria);
                                        while($row_auditoria = mysqli_fetch_assoc($exec_select_auditoria)){
                    ?>
                                            <tr>
                                                <td><?php echo $row_auditoria['id_agendamentos']; ?></td>
                                                <td><?php echo $row_auditoria['nome_completo_func']; ?></td>
                                                <td><?php echo $row_auditoria['desc_unidade']; ?></td>
                                                <td><?php echo $row_auditoria['data_cadastro_agendamento']; ?></td>
                                                <td><?php echo $row_auditoria['reagendado']; ?></td>
                                                <td><center><?php  echo "<a href='actions/act_registra_log.php?idagdm=".$row_auditoria['id_agendamentos']."&acao=1' target = '_blank'><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center></td>
                                            </tr>
                    <?php

                                        };
                                    }else if($filtro_periodo == 1){
                                        //PEGA PERÍODO ESPECÍFICO
                                        $inicio = $_GET['data_inicial'];
                                        $final = $_GET['data_final'];
                                        $select_auditoria = "SELECT * FROM agendamentos ag
                                        INNER JOIN funcionario func ON ag.id_func = func.id_func
                                        INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade
                                        WHERE ag.id_status_auditoria = '1' AND ag.id_func = '$idfunc' AND date(ag.data_cadastro_agendamento) BETWEEN '$inicio' AND '$final' ORDER BY date(ag.data_cadastro_agendamento) ASC";
                                        $exec_select_auditoria = mysqli_query($conn, $select_auditoria);
                                        while($row_auditoria = mysqli_fetch_assoc($exec_select_auditoria)){
                    ?>
                                            <tr>
                                                <td><?php echo $row_auditoria['id_agendamentos']; ?></td>
                                                <td><?php echo $row_auditoria['nome_completo_func']; ?></td>
                                                <td><?php echo $row_auditoria['desc_unidade']; ?></td>
                                                <td><?php echo $row_auditoria['data_cadastro_agendamento']; ?></td>
                                                <td><?php echo $row_auditoria['reagendado']; ?></td>
                                                <td><center><?php  echo "<a href='actions/act_registra_log.php?idagdm=".$row_auditoria['id_agendamentos']."&acao=1' target = '_blank'><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center></td>
                                            </tr>
                    <?php

                                        };
                                    }
                                }
                        }else{
                            //PESQUISA POR SCOUTER ESPECÍFICO
                            if($filtro_periodo == 0){
                                //PEGA TODOS OS PERÍODOS
                                $select_auditoria = "SELECT * FROM agendamentos ag INNER JOIN funcionario func ON ag.id_func = func.id_func INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade WHERE ag.id_status_auditoria = '1' AND ag.id_func = '$filtro_scouter' ORDER BY date(ag.data_cadastro_agendamento) ASC";
                                $exec_select_auditoria = mysqli_query($conn, $select_auditoria);
                                while($row_auditoria = mysqli_fetch_assoc($exec_select_auditoria)){
                    ?>
                                            <tr>
                                                <td><?php echo $row_auditoria['id_agendamentos']; ?></td>
                                                <td><?php echo $row_auditoria['nome_completo_func']; ?></td>
                                                <td><?php echo $row_auditoria['desc_unidade']; ?></td>
                                                <td><?php echo $row_auditoria['data_cadastro_agendamento']; ?></td>
                                                <td><?php echo $row_auditoria['reagendado']; ?></td>
                                                <td><center><?php  echo "<a href='actions/act_registra_log.php?idagdm=".$row_auditoria['id_agendamentos']."&acao=1' target = '_blank'><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center></td>
                                            </tr>
                    <?php

                                        };
                            }else if($filtro_periodo == 1){
                                //PEGA PERÍODO ESPECÍFICO
                                 $inicio = $_GET['data_inicial'];
                                $final = $_GET['data_final'];
                                $select_auditoria = "SELECT * FROM agendamentos ag INNER JOIN funcionario func ON ag.id_func = func.id_func INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade WHERE ag.id_status_auditoria = '1' AND ag.id_func = '$filtro_scouter' AND date(ag.data_cadastro_agendamento) BETWEEN '$inicio' AND '$final' ORDER BY date(ag.data_cadastro_agendamento) ASC";
                               
                                $exec_select_auditoria = mysqli_query($conn, $select_auditoria);
                                while($row_auditoria = mysqli_fetch_assoc($exec_select_auditoria)){
                    ?>
                                            <tr>
                                                <td><?php echo $row_auditoria['id_agendamentos']; ?></td>
                                                <td><?php echo $row_auditoria['nome_completo_func']; ?></td>
                                                <td><?php echo $row_auditoria['desc_unidade']; ?></td>
                                                <td><?php echo $row_auditoria['data_cadastro_agendamento']; ?></td>
                                                <td><?php echo $row_auditoria['reagendado']; ?></td>
                                                <td><center><?php  echo "<a href='actions/act_registra_log.php?idagdm=".$row_auditoria['id_agendamentos']."&acao=1' target = '_blank'><img src='images/audit.png' width='48px' height='48px' title='Auditar Agendamento'></a>"; ?></center></td>
                                            </tr>
                    <?php

                                        };
                            }
                        }
                    }
                    ?>       
                      
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