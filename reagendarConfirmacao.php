<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_scouter_ligacao_new'] == 1){
    include_once("conection/connection.php");
    $pdo=conectar();
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
<!--  INICIO DE FORM DE CADASTRO  -->
     <?php
                        if(isset($_SESSION['msgcad'])){
                            echo $_SESSION['msgcad'];
                            unset($_SESSION['msgcad']);
                        };
                        ?> 

        <div class="content mt-3">
            <div class="col-sm-12" > 
                <div class="col-lg-6">
                    <div class="card" style="max-width: 900px; width: 800px;">
                      <div class="card-header" style="max-width: 900px; width: 800px;">                        
                        <strong>Reagendar</strong> Cliente   - &nbsp;&nbsp;&nbsp;&nbsp; 

                            <!-- <a href="confirmacaonew.php"><img src="../images/back.png" width="30px" height="30px"></a> -->
                        
                      </div>
                      <div class="card-body card-block"> 
                         <?php 
                            if(!empty($_GET['ag']) && !empty($_GET['cli'])){
                            $idCliente = $_GET['cli'];
                            $idAgendamento = $_GET['ag']; 

                            $pesquisarCliente=$pdo->prepare("SELECT * FROM cliente WHERE id_cliente=:idCli");
                            $pesquisarCliente->bindValue(":idCli", $idCliente);
                            $pesquisarCliente->execute();
                            $rowCliente=$pesquisarCliente->fetch(PDO::FETCH_OBJ);  

                            if(!empty($_GET['conf'])){
                                $conf=1;
                                $pesquisaAgendamento=$pdo->prepare("SELECT * FROM agendamentos ag INNER JOIN funcionario func ON ag.id_func = func.id_func WHERE ag.id_agendamentos=:idAgendamento");
                                $pesquisaAgendamento->bindValue(":idAgendamento", $idAgendamento);
                                $pesquisaAgendamento->execute();
                                $rowAgendamento=$pesquisaAgendamento->fetch(PDO::FETCH_OBJ);
                                $scouterReagendamento=$rowAgendamento->nome_completo_func;
                                $idScouterReagendamento=$rowAgendamento->id_func;
                                $meioCaptado=$rowAgendamento->id_meio_captado;
                            }else{
                                $conf=0;
                            };
                        ?> 
                        <form action="actions/actReagendarClienteConfirmacao.php?ag=<?php echo $_GET['ag']; ?>&cli=<?php echo $_GET['cli']; ?>&conf=<?php echo $conf; ?>&funcAg=<?php echo $idScouterReagendamento; ?>&meioCap=<?php echo $meioCaptado ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                        <?php
                            if($conf == 1){                                 
                        ?>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Scouter do Agendamento: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefoneprincipal" placeholder="" class="form-control" value="<?php 
                                echo $scouterReagendamento; 
                            ?>" disabled="true"><small class="form-text text-muted"></small></div>
                          </div>
                          <?php
                            };
                          ?>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome:</labelcan></div>
                            <div class="col-12 col-md-9">                              
                           <input type="text" id="email-input" name="nomeCliente" placeholder="" class="form-control" value="<?php 
                            if(!empty($rowCliente->nome_cliente)){ 
                            echo $rowCliente->nome_cliente;
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true">                         
                            <!--
                            <button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#mediumModal" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Cliente</small> -->
                            
                            <!-- <a href="pesquisar_cliente_ligacao.php"><button type="button" class="btn btn-secondary mb-1" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Meus Clientes </small></a> -->
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefone Principal: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefoneprincipal" placeholder="" class="form-control" value="<?php 
                            if(!empty($rowCliente->telefone_cliente)){
                            echo $rowCliente->telefone_cliente;
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"><small class="form-text text-muted"></small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome do Responsável:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="responsavel" placeholder="" class="form-control" value="<?php 
                            if(!empty($rowCliente->nome_responsavel_cliente)){
                            echo $rowCliente->nome_responsavel_cliente;
                            }else{
                                echo ""; 
                            } 
                            ?>" disabled="true"><small class="form-text text-muted"> --</small></div>       
                          </div>                          
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data Reagendamento: </label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="dataAgendado" placeholder="" class="form-control" required></div>
                          </div>                               
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Hora reagendada: </label></div>
                            <div class="col-12 col-md-9"><input type="time" id="text-input" name="horaAgendado" placeholder="" class="form-control" required></div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Unidade:</label></div>
                            <div class="col-12 col-md-9">
                              <select name="select_unidade" id="select" class="form-control">
                                <?php 
                                    $pesquisaUnidade=$pdo->prepare("SELECT id_unidade, desc_unidade FROM unidade WHERE id_unidade = :unidade");
                                    $pesquisaUnidade->bindValue(":unidade", $unidadefunc);
                                    $pesquisaUnidade->execute();
                                    $linhaUnidade=$pesquisaUnidade->fetchall(PDO::FETCH_OBJ);

                                    foreach($linhaUnidade as $rowUnidade){
                                ?>
                                <option value="<?php echo $rowUnidade->id_unidade; ?>"><?php echo $rowUnidade->desc_unidade;  ?></option>
                               <?php
                                    }
                               ?>
                              </select>
                            </div>
                          </div>                           
                      </div>
                      <div class="card-footer">
                        <button type="submit" name="btn_cadastro_agendamento" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Reagendar Cliente
                        </button>
                        </form>
                        <?php
                            }else{
                                if(!empty($_SESSION['msgcad'])){
                        ?>
                            <div class='alert alert-danger' role='alert'>
                                            Houve uma Falha ao Tentar Captar o seu Agendamento. Tente refazer a operação. 
                             </div>
                        <?php
                            }else{ 

                            }
                        }
                        ?>
                      </div>
                    </div>
        <!-- FIM DE FORM DE CADASTRO -->
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