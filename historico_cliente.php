<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_gerencia'] == 1){
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
                            $idcliente = $_GET['idcli'];
                            $select_cliente = "SELECT * FROM cliente cli INNER JOIN funcionario fun ON cli.id_func = fun.id_func WHERE cli.id_cliente = '$idcliente'";
                            $exec_select_cliente = mysqli_query($conn, $select_cliente);
                            $row_cliente = mysqli_fetch_assoc($exec_select_cliente);

                        ?>
                       
                        <strong>Histórico</strong> de Cliente                        
                      </div>
                      <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>ID Cliente:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_cliente['id_cliente'];
                              ?>
                            </div>                          
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Scouter:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_cliente['nome_completo_func'];
                              ?>
                            </div>                          
                          </div>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Nome:</b><b><font color="red"></font></b></labelcan></div>
                            <div class="col-12 col-md-9">   
                            <?php
                              echo $row_cliente['nome_cliente'];
                            ?>            
                           
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
                                echo $row_cliente['idade_cliente'];
                              ?>
                            </small></div>
                          </div>                                                
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Telefone Principal:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_cliente['telefone_cliente']."-(".strlen($row_cliente['telefone_cliente']).")";
                              ?>
                            <small class="form-text text-muted"></small></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Telefone Secundário:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                              if(!empty($row_cliente['telefone2_cliente'])){
                                echo $row_cliente['telefone2_cliente']."-(".strlen($row_cliente['telefone2_cliente']).")";
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
                                if(!empty($row_cliente['nome_responsavel_cliente'])){
                                  echo $row_cliente['nome_responsavel_cliente'];
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
                                if(!empty($row_cliente['email_cliente'])){
                                  echo $row_cliente['email_cliente'];
                                }else{
                                  echo "Não Possui";
                                }
                              ?>
                            <small class="help-block form-text"></small></div>
                          </div> 
                          <?php
                            if($row_cliente['id_meio_captado'] == 1){
                          ?>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label"><b>Meio Captado:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              Instagram
                            </div>
                          </div>                                                       
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label"><b>Instagram:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                $instagram = $row_cliente['url_instagram'];
                                echo $instagram." | <a href='http://www.instagram.com/$instagram/' target='_blank'>Acessar</a>";
                              ?>                              
                            </div>
                          </div>  
                          <?php
                            }else{
                            ?>
                              <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label"><b>Meio Captado:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              Ligação
                            </div>
                          </div> 
                              <?php
                            }
                          ?>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Data de Cadastro:</b><b><font color="red"></font></b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_cliente['data_cadastro_cliente'];
                              ?>
                            </div>
                          </div>    
                          <?php
                            if($row_cliente['id_meio_captado'] == 1){
                          ?>
                          <div class="row form-group">
                            <div class="col-12 col-md-9">

                              <table border="1">                                
                                  <?php
                                    $select_agendamentos = "SELECT * FROM agendamentos ag
                                    INNER JOIN conta_utilizada ca ON ag.id_conta_utilizada = ca.id_conta_utilizada
                                    INNER JOIN funcionario fun ON ag.id_func = fun.id_func
                                    INNER JOIN status_auditoria sa ON ag.id_status_auditoria = sa.id_status_auditoria
                                    INNER JOIN unidade uni ON ag.id_unidade = uni.id_unidade
                                    INNER JOIN status_comparecimento sc ON ag.id_comparecimento = sc.id_comparecimento
                                     WHERE ag.id_cliente = '$idcliente'";
                                    $exec_select_agendamentos = mysqli_query($conn, $select_agendamentos);
                                    while($row_agendamentos = mysqli_fetch_assoc($exec_select_agendamentos)){
                                  ?>
                                  <tr>
                                    <th colspan="2" style="background-color: black;color: white;">Identificação do Agendamento -> <?php echo $row_agendamentos['id_agendamentos']; ?> | Reagendado: <?php echo $row_agendamentos['reagendado']; ?></th>                      
                                  </tr> 
                                  <tr>
                                    <td colspan="2">Informações Agendamento</td>
                                  </tr>                                 
                                  <tr>
                                    <td>Data Agendado:</td>
                                    <td><?php echo $row_agendamentos['data_agendada_agendamento']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Hora Agendado:</td>
                                    <td><?php echo $row_agendamentos['hora_agendada_agendamento']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Data Cadastrado:</td>
                                    <td><?php echo $row_agendamentos['data_cadastro_agendamento']; ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><b>Informações Instagram</b></td>
                                  </tr>
                                  <tr>
                                    <td>Conta Utilizada:</td>
                                    <td><?php echo $row_agendamentos['nome_conta_utilizada']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Scouter:</td>
                                    <td><?php echo $row_agendamentos['nome_completo_func'];  ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><b>Informações Auditoria</b></td>
                                  </tr>
                                  <tr>
                                    <td>Status Auditoria:</td>
                                    <td><?php echo $row_agendamentos['descricao_status_auditoria']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Auditor:</td>
                                    <td><?php echo $row_agendamentos['auditor_agendamentos']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Hora Auditado:</td>
                                    <td><?php echo $row_agendamentos['hora_auditoria']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Motivo Reprovado</td>
                                    <td><?php echo $row_agendamentos['motivo_reprovacao_auditoria']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Autorizada Re-Análise</td>
                                    <td><?php echo $row_agendamentos['aut_re_analise_auditoria']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Última Réplica</td>
                                    <td><?php echo $row_agendamentos['motivo_reanalise_auditoria']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Quantidade Re-Análisada:</td>
                                    <td><?php echo $row_agendamentos['qtd_re_analise_auditoria']; ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><b>Informações de Confirmação</b></td>
                                  </tr>
                                  <tr>
                                    <td>Confirmado:</td>
                                    <td>
                                    <?php 
                                      if($row_agendamentos['confirmado'] == 1){
                                        echo "Sim";
                                      }else{
                                        echo "Não";
                                      };
                                    ?></td>
                                  </tr>
                                  <tr>
                                    <td>Funcionário da Confirmação: </td>
                                    <td><?php echo $row_agendamentos['id_func_conf']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Hora Confirmado: </td>
                                    <td><?php echo $row_agendamentos['confirmado_hour']; ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><b>Informações da Agência</b></td>
                                  </tr>
                                  <tr>
                                    <td>Unidade:</td>
                                    <td><?php echo $row_agendamentos['desc_unidade']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Comparecimento:</td>
                                    <td><?php echo $row_agendamentos['desc_comparecimento']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Recepcionista:</td>
                                    <td><?php echo $row_agendamentos['recep_comparecimento']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Hora Presença:</td>
                                    <td><?php echo "00:00:00"; ?></td>
                                  </tr>
                                  <?php
                                    };
                                  ?>
                              </table>

                            </div>
                          </div>    
                          <?php
                            }else if($row_cliente['id_meio_captado'] == 3){
                              //TABLE DE LIGACAO

                            }
                          ?>

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