<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_gerencia'] == 1){
    include_once("conection/connection.php");
    $pdo=conectar();
    //include_once("php/verificar_sessao.php");
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
                        <strong>Encaminhar</strong> Agendamento de Recuperação para Colaborador
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>
                      <div class="card-body card-block">
                        <form action="actions/actLiberarAgendamentos.php" method="post" enctype="multipart/form-data" class="form-horizontal" onclick="<script language='JavaScript'>confirm('Deseja Realmente Liberar as Fichas?');</script>">
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">  Stand By:</label></div>
                            <div class="col-12 col-md-9">
                                <?php

                                    $quantidadeAgend=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_agendada_agendamento) >= '2019-10-01' AND date(data_agendada_agendamento) < date(NOW()) AND id_unidade=:unidadeGerente AND id_comparecimento=:comparecimento AND func_recuperacao=:funcRec");
                                    $quantidadeAgend->bindValue(":unidadeGerente", $unidadefunc);
                                    $quantidadeAgend->bindValue(":comparecimento", 3);
                                    $quantidadeAgend->bindValue(":funcRec", 0);
                                    $quantidadeAgend->execute();
                                    $qtdFinalAgend=$quantidadeAgend->rowCount();
                                    echo $qtdFinalAgend;

                                    $qtdInsta=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_agendada_agendamento) >= '2019-10-01' AND date(data_agendada_agendamento) < date(NOW()) AND id_unidade=:unidadeGerente AND id_comparecimento=:comparecimento AND func_recuperacao=:funcRec AND id_meio_captado=:meioCaptado");
                                    $qtdInsta->bindValue(":unidadeGerente", $unidadefunc);
                                    $qtdInsta->bindValue(":comparecimento", '3');
                                    $qtdInsta->bindValue(":funcRec", '0');
                                    $qtdInsta->bindValue(":meioCaptado", '1');
                                    $qtdInsta->execute();
                                    $qtdFinalInsta=$qtdInsta->rowCount();

                                    $qtdWts=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_agendada_agendamento) >= '2019-10-01' AND date(data_agendada_agendamento) < date(NOW()) AND id_unidade=:unidadeGerente AND id_comparecimento=:comparecimento AND func_recuperacao=:funcRec AND id_meio_captado=:meioCaptado");
                                    $qtdWts->bindValue(":unidadeGerente", $unidadefunc);
                                    $qtdWts->bindValue(":comparecimento", 3);
                                    $qtdWts->bindValue(":funcRec", 0);
                                    $qtdWts->bindValue(":meioCaptado", 2);
                                    $qtdWts->execute();
                                    $qtdFinalWts=$qtdWts->rowCount();

                                    $qtdLig=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_agendada_agendamento) >= '2019-10-01' AND date(data_agendada_agendamento) < date(NOW()) AND id_unidade=:unidadeGerente AND id_comparecimento=:comparecimento AND func_recuperacao=:funcRec AND id_meio_captado=:meioCaptado");
                                    $qtdLig->bindValue(":unidadeGerente", $unidadefunc);
                                    $qtdLig->bindValue(":comparecimento", 3);
                                    $qtdLig->bindValue(":funcRec", 0);
                                    $qtdLig->bindValue(":meioCaptado", 3);
                                    $qtdLig->execute();
                                    $qtdFinalLig=$qtdLig->rowCount();

                                    $qtdFace=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_agendada_agendamento) >= '2019-10-01' AND date(data_agendada_agendamento) < date(NOW()) AND id_unidade=:unidadeGerente AND id_comparecimento=:comparecimento AND func_recuperacao=:funcRec AND id_meio_captado=:meioCaptado");
                                    $qtdFace->bindValue(":unidadeGerente", $unidadefunc);
                                    $qtdFace->bindValue(":comparecimento", 3);
                                    $qtdFace->bindValue(":funcRec", 0);
                                    $qtdFace->bindValue(":meioCaptado", 4);
                                    $qtdFace->execute();
                                    $qtdFinalFace=$qtdFace->rowCount(); 

                                
                                ?>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Método de Captação:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="metodoCaptacao" class="form-control">                                    
                                    <option value="1">Instagram - <?php echo $qtdFinalInsta; ?></option>
                                    <option value="2">Whatsapp - <?php echo $qtdFinalWts; ?></option>
                                    <option value="3">Ligação - <?php echo $qtdFinalLig; ?></option>   
                                    <option value="4">Facebook - <?php echo $qtdFinalFace; ?></option>                                   
                                </select>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Quantidade Liberar:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="qtd_fichas" placeholder="" class="form-control" required></div>
                          </div>  
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Colaborador:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="idColaborador" class="form-control">
                                <?php
                                    $funcGerente=$pdo->prepare("SELECT * FROM funcionario WHERE menu_scouter_ligacao_new=:menuScouter AND id_unidade=:unidade ORDER BY nome_completo_func ASC");
                                    $funcGerente->bindValue(":menuScouter", 1);
                                    $funcGerente->bindValue(":unidade", $unidadefunc);
                                    $funcGerente->execute();
                                    $linhaFuncGerente=$funcGerente->fetchall(PDO::FETCH_OBJ);

                                   foreach($linhaFuncGerente as $rowFuncGerente){
                                ?>
                                    <option value="<?php echo $rowFuncGerente->id_func; ?>"> 
                                        <?php echo $rowFuncGerente->nome_completo_func; ?>               
                                    </option>
                                <?php
                                    };
                                ?>
                                </select>
                            </div>
                          </div>                  
                        
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Liberar Agendamentos
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
