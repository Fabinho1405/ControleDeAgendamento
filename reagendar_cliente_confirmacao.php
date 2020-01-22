<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1){
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
                            if(!empty($_GET['idagendamento'])){
                            $id_agendamento = $_GET['idagendamento'];
                            $pesquisar_agendamento = "SELECT * FROM agendamentos ag 
                            INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente 
                            INNER JOIN funcionario fun ON ag.id_func = fun.id_func
                            INNER JOIN meio_captado mc ON ag.id_meio_captado = mc.id_meio_captado
                            WHERE id_agendamentos = '$id_agendamento'";
                            $exec_pesquisar_agendamento = mysqli_query($conn, $pesquisar_agendamento);                  
                           $row_reagendar = mysqli_fetch_assoc($exec_pesquisar_agendamento);
                            }else{

                            } 

                        ?> 
                        <strong>Reagendar</strong> Cliente da Confirmação
                        
                      </div>
                      <div class="card-body card-block">
                        <form action="actions/act_reagendar_cliente_confirmacao.php?id=<?php echo $_GET['idagendamento']; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">

                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome:</labelcan></div>
                            <div class="col-12 col-md-9">                              
                           <input type="text" id="email-input" name="nomecliente" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_cliente'])){
                            echo $row_reagendar['nome_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"></small>
                         
                            <!--
                            <button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#mediumModal" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Cliente</small> -->
                            
                           <!--  <a href="pesquisar_cliente_ligacao.php"><button type="button" class="btn btn-secondary mb-1" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Meus Clientes </small></a> -->
                            </div>
                          </div>
                         
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefone Principal: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefoneprincipal" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"><small class="form-text text-muted"></small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome do Responsável:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="responsavel" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_responsavel_cliente'])){
                            echo $row_reagendar['nome_responsavel_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"></div>       
                          </div>       
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Scouter:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="scouter" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_completo_func'])){
                            echo $row_reagendar['nome_completo_func'];
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"></div>        
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Meio Captado:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="meiocaptado" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['descricao_meio_captado'])){
                            echo $row_reagendar['descricao_meio_captado'];
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"></div>       
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Cadastro do Agendamento:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="responsavel" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['data_cadastro_agendamento'])){
                            echo $row_reagendar['data_cadastro_agendamento'];
                            }else{
                                echo "";
                            } 
                            ?>" disabled="true"></div>       
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data Reagendamento: </label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_agendado" placeholder="" class="form-control"><small class="form-text text-muted"></small></div>
                          </div>                               
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Hora reagendada: </label></div>
                            <div class="col-12 col-md-9"><input type="time" id="text-input" name="hora_agendado" placeholder="" class="form-control"><small class="form-text text-muted"></small></div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Unidade:</label></div>
                            <div class="col-12 col-md-9">
                              <select name="select_unidade" id="select" class="form-control">
                                <?php 
                                    $result_unidades = "SELECT id_unidade, desc_unidade FROM unidade"; 
                                    $resultado_unidades = mysqli_query($conn, $result_unidades);
                                    while($row_unidades = mysqli_fetch_assoc($resultado_unidades)){ 
                                ?>
                                <option value="<?php echo $row_unidades['id_unidade']; ?>"><?php echo $row_unidades['desc_unidade'];  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>
                          </div>                           
                      </div>
                      <div class="card-footer">
                        <button type="submit" name="btn_cadastro_agendamento" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Reagendar
                        </button>
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