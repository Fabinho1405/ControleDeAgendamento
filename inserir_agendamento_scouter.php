<?php
    session_start();
    include_once("conection/conexao.php");
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_gerencia']){    
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
                        <!-- ID DO USUARIO 
                        <?php  echo $_SESSION['id_usuario'];  ?>
                        -->
                        <strong>Cadastro</strong> de Agendamento                    
                      </div>
                      <div class="card-body card-block">
                        <form action="actions/act_cadastrar_agendamento_scouter.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome:<b><font color="red">*</font></b></labelcan></div>
                            <div class="col-12 col-md-9">                              
                           <input type="text" id="email-input" name="nomecliente" placeholder="" class="form-control" value="<?php
                           if(!empty($_GET['nomemodelo'])){
                            echo $_GET['nomemodelo']; 
                            }else{
                                echo "";
                            }
                            ?>"><small class="help-block form-text"></small>
                            <!--
                            <button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#mediumModal" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Cliente</small> -->
                            
                            <!--<a href="pesquisar_cliente.php"><button type="button" class="btn btn-secondary mb-1" style="background: transparent; border: none;"><img src="images/abrircliente.png" width="32px" height="32px"> </button> Pesquisar Cliente (Caso haja um reagendamento) </small></a> -->
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Idade:<b><font color="red">*</font></b> </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="idade_cliente" placeholder="" class="form-control" value="" maxlength="2"><small class="form-text text-muted"></small></div>
                          </div>
                         
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefone Principal:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefoneprincipal" placeholder="" class="form-control" value="<?php 
                            if(!empty($_GET['telefoneprincipal'])){
                            echo $_GET['telefoneprincipal'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefone Secundário: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefonesecundario" placeholder="" class="form-control" value="<?php 
                            if(!empty($_GET['telefonesecundario'])){
                            echo $_GET['telefonesecundario'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome do Responsável:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="responsavel" placeholder="" class="form-control" value="<?php
                            if(!empty($_GET['nomeresponsavel'])){
                             echo $_GET['nomeresponsavel'];
                            }else{
                                echo "";
                            }
                             ?>"><small class="form-text text-muted"> --</small></div>
                            
                          </div>                                      
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Data de agendamento:<b><font color="red">*</font></b> </label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="data_agendado" placeholder="" class="form-control"><small class="form-text text-muted"></small></div>
                          </div>                               
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Hora agendada:<b><font color="red">*</font></b> </label></div>
                            <div class="col-12 col-md-9"><input type="time" id="text-input" name="hora_agendado" placeholder="" class="form-control"><small class="form-text text-muted"></small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Conta Captação:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-9">
                              <select name="select_conta" id="select" class="form-control">
                                <option value="0">Nenhuma</option>
                                <?php 
                                    $result_contas_insta = "SELECT id_conta_utilizada, nome_conta_utilizada FROM conta_utilizada WHERE status = '1'"; 
                                    $resultado_contas_insta = mysqli_query($conn, $result_contas_insta);
                                    while($row_contas_insta = mysqli_fetch_assoc($resultado_contas_insta)){ 
                                ?>
                                <option value="<?php echo $row_contas_insta['id_conta_utilizada']; ?>"><?php echo $row_contas_insta['nome_conta_utilizada'];  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>
                          </div>  
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Url:<b><font color="red">*</font></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Instagram.com/</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="urlinsta" placeholder="" class="form-control"></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Scouter<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-9">
                              <select name="select_scouter" id="select" class="form-control">
                                <?php 
                                    $result_unidades = "SELECT * FROM funcionario WHERE id_locado = '4' AND status_sistema = '1' ORDER BY nome_completo_func ASC"; 
                                    $resultado_unidades = mysqli_query($conn, $result_unidades);
                                    while($row_unidades = mysqli_fetch_assoc($resultado_unidades)){ 
                                ?>
                                <option value="<?php echo $row_unidades['id_func']; ?>"><?php echo $row_unidades['nome_completo_func'];  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>
                          </div> 
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Unidade:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-9">
                              <select name="select_unidade" id="select" class="form-control">
                                <?php 
                                    $result_unidades = "SELECT id_unidade, desc_unidade FROM unidade WHERE status = '1'"; 
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
                          
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Status:</label></div>
                            <div class="col-12 col-md-9">
                              <p class="form-control-static">Encaminhado para Auditoria</p><small class="form-text text-muted">Utilizado para controle interno.</small>
                            </div>                          
                          </div> 
                        </div>
                      <div class="card-footer">
                        <button type="submit" name="" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Cadastrar Agendamento
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
        //LOG
            $ip_log = $_SERVER['REMOTE_ADDR'];
            $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'tentativa de acessar pagina nao permitida/sem acesso', 'PERIGO', '0');";
            $exec_insert_log = mysqli_query($conn, $insert_log);
        //FIM LOG
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>