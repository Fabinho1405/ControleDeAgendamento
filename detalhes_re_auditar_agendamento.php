<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1){
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
         ?> 
      <!-- /header -->
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
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $result_usuario = "SELECT * FROM cliente WHERE id_cliente = '$id'";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
    ?>
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
                        
                        <?php
                            $idagendamento = $_GET['idagdm'];
                            $select_agendamento = "SELECT * FROM agendamentos ag 
                            INNER JOIN conta_utilizada cu ON ag.id_conta_utilizada = cu.id_conta_utilizada
                            INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente
                            INNER JOIN meio_captado mc ON ag.id_meio_captado = mc.id_meio_captado
                            INNER JOIN unidade un ON ag.id_unidade = un.id_unidade
                            INNER JOIN funcionario fun ON ag.id_func = fun.id_func
                            WHERE id_agendamentos = '$idagendamento'";
                            $exec_select_agendamento = mysqli_query($conn, $select_agendamento);
                            $row_agendamento = mysqli_fetch_assoc($exec_select_agendamento);

                        ?>
                       
                        <strong>Detalhes</strong> de Re-Análise de  Agendamento                        
                      </div>
                      <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>ID Agendamento:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['id_agendamentos'];
                              ?>
                            </div>                          
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Scouter:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['nome_completo_func'];
                              ?>
                            </div>                          
                          </div>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Nome:</b><b><font color="red"></font></b></labelcan></div>
                            <div class="col-12 col-md-9">   
                            <?php
                              echo $row_agendamento['nome_cliente'];
                            ?>            
                           <a href="#" onclick="window.open('modificar_cliente.php?idagdm=<?php echo $idagendamento; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=30, LEFT=70, WIDTH=800, HEIGHT=600');">MODIFICAR CLIENTE</a>

                           <small class="help-block form-text"></small>
                            <!--
                            <button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#mediumModal" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Cliente</small> -->
                            
                            <!--<a href="pesquisar_cliente.php"><button type="button" class="btn btn-secondary mb-1" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Cliente (Caso haja um reagendamento) </small></a> -->
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Idade:</b><b><font color="red"></font></b> </label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['idade_cliente'];
                              ?>
                            </small></div>
                          </div>                                                
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Telefone Principal:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['telefone_cliente']."-(".strlen($row_agendamento['telefone_cliente']).")";
                              ?>
                            <small class="form-text text-muted"></small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Telefone Secundário:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                              if(!empty($row_agendamento['telefone2_cliente'])){
                                echo $row_agendamento['telefone2_cliente']."-(".strlen($row_agendamento['telefone2_cliente']).")";
                              }else{
                                echo "Não Possui";
                              }

                              ?>
                            <small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Nome do Responsável:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                if(!empty($row_agendamento['nome_responsavel_cliente'])){
                                  echo $row_agendamento['nome_responsavel_cliente'];
                                }else{
                                  echo "O mesmo";
                                }
                              ?>
                            <small class="form-text text-muted"> --</small></div>
                           </div>
                        
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="email-input" class=" form-control-label"><b>Email:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                if(!empty($row_agendamento['email_cliente'])){
                                  echo $row_agendamento['email_cliente'];
                                }else{
                                  echo "Não Possui";
                                }
                              ?>
                            <small class="help-block form-text"></small></div>
                          </div>               
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Conta Captação:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                              if(!empty($row_agendamento['nome_conta_utilizada'])){
                                echo $row_agendamento['nome_conta_utilizada'];
                              }else{

                              }
                              ?>
                            </div>
                          </div>                        
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Data de agendamento:</b><b><font color="red"></font></b> </label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo date('d/m/Y', strtotime($row_agendamento['data_agendada_agendamento']));
                              ?>
                            <small class="form-text text-muted"></small></div>
                          </div>                               
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Hora agendada:</b><b><font color="red"></font></b> </label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['hora_agendada_agendamento'];
                              ?> 
                            <small class="form-text text-muted"></small></div>
                          </div>
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label"><b>Instagram:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                $instagram = $row_agendamento['url_instagram'];
                                echo $instagram." | <a href='http://www.instagram.com/$instagram/' target='_blank'>Acessar</a>";
                              ?>                              
                            </div>
                          </div>                           
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Unidade:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['desc_unidade'];
                              ?>
                            </div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Motivo Negado:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['motivo_reprovacao_auditoria'];
                              ?>
                            </div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Réplica do Scouter:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_agendamento['motivo_reanalise_auditoria'];
                              ?>
                            </div>
                          </div>     

                      </div>
                      <div class="card-footer">
                        <a href="<?php echo 'actions/act_auditoria_agendamento.php?dec=2&idagdm='.$idagendamento.''?>">
                        <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-rss"></i>&nbsp;Reprovado</button>
                      </a>

                        <a href="<?php echo 'actions/act_auditoria_agendamento.php?dec=4&idagdm='.$idagendamento.''?>">
                        <button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-magic"></i>&nbsp; Aprovado</button>
                      </a>

                    </div>
                        </form>                       
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