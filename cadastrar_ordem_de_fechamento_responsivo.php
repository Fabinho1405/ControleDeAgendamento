<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1){
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
            <div class="col-sm-24" >
                <div class="col-lg-6">
                    <div class="card" style="max-width: 900px; width: 800px;">
                      <div class="card-header" style="max-width: 900px; width: 800px;">
                       
                        <?php 
                            if(!empty($_GET['id'])){
                            $id_cliente = $_GET['id'];
                            $pesquisar_cliente = "SELECT * FROM cliente WHERE id_cliente = $id_cliente";
                            $exec_pesquisar_cliente = mysqli_query($conn, $pesquisar_cliente);                  
                           $row_reagendar = mysqli_fetch_assoc($exec_pesquisar_cliente);
                            }else{

                            }

                        ?> 
                        <strong>Cadastrar</strong> Ordem de Fechamento 
                        
                      </div>
                      <div class="card-body card-block">
                        <form action="actions/act_registrar_ordem_fechamento.php?un=<?php echo $unidadefunc ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome do Modelo:</labelcan></div>
                            <div class="col-12 col-md-9">                              
                           <input type="text" id="email-input" name="nome_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_cliente'])){
                            echo $row_reagendar['nome_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"></small>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">RG do Modelo: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="rg_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">CPF do Modelo: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="cpf_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome do Responsável:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="responsavel_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_responsavel_cliente'])){
                            echo $row_reagendar['nome_responsavel_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"> --</small></div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">RG do Responsável:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="rg_responsavel" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_responsavel_cliente'])){
                            echo $row_reagendar['nome_responsavel_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"> --</small></div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">CPF do Responsável:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="cpf_responsavel" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_responsavel_cliente'])){
                            echo $row_reagendar['nome_responsavel_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"> --</small></div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nascimento do Modelo:</label></div>
                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="nascimento_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_responsavel_cliente'])){
                            echo $row_reagendar['nome_responsavel_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"> --</small></div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Idade do Modelo:</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="idade_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['nome_responsavel_cliente'])){
                            echo $row_reagendar['nome_responsavel_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"> --</small></div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Estado Civil:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="civil_modelo" class="form-control">
                                    <option value="Solteiro">Solteiro</option>
                                    <option value="Casado"> Casado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Não Informou">Não Informou</option>                                 
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">CEP: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="cep_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Endereço: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="endereco_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Número: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="numero_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Complemento: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="complemento_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Bairro: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="bairro_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefone Principal: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefoneprincipal_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Telefone Secundário: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="telefonesecundario_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>                           

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Instagram: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="instagram_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div> 

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Facebook: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="facebook_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">E-mail: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="email_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome Artístico: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="nome_artistico_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Altura: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="altura_modelo" placeholder="Utilize a unidade de medida em centímetros" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Peso: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="peso_modelo" placeholder="Utilize a unidade de medida em Kilos" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Manequim: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="manequim_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Sapato: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="sapato_modelo" placeholder="" class="form-control" value="<?php 
                            if(!empty($row_reagendar['telefone_cliente'])){
                            echo $row_reagendar['telefone_cliente'];
                            }else{
                                echo "";
                            } 
                            ?>"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Cor dos Olhos:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="olhos_modelo" class="form-control">
                                    <option value="Não Informado">Não Informado</option>
                                    <option value="Azul">Azul</option>
                                    <option value="Verde">Verde</option>
                                    <option value="Castanho Claro">Castanho Claro</option>
                                    <option value="Castanho Escuto">Castanho Escuro</option>                           
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Cor do Cabelo:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="cabelo_modelo" class="form-control">
                                    <option value="Não Informado">Não Informado</option>
                                    <option value="Castanho Claro">Castanho Claro</option>
                                    <option value="Castanho Escuro">Castanho Escuro</option>
                                    <option value="Preto">Preto</option>
                                    <option value="Loiro">Loiro</option>                               
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Etnia:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="etnia_modelo" class="form-control">
                                    <option value="Não Informado">Não Informado</options>
                                    <option value="Branco">Branco</option>
                                    <option value="Negro">Negro</option>
                                    <option value="Pardo">Pardo</option>
                                    <option value="Albino">Albino</option>                                 
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Material:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="material_modelo" class="form-control">
                                    <option value="Agenciamento">Agênciamento</option>
                                    <option value="B1">Book Fotográfico TIPO 1</option>
                                    <option value="B2">Book Fotográfico TIPO 2</option>
                                    <option value="B3">Book Fotográfico TIPO 3</option>
                                    <option value="B4">Book Fotográfico TIPO 4</option>                            
                                </select>
                            </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Produtor:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-9">
                              
                              <select name="select_produtor" id="select" class="form-control">
                                <?php 
                                    $result_produtor = "SELECT * FROM funcionario WHERE menu_produtor = '1' AND id_unidade = '$unidadefunc'"; 
                                    $resultado_produtor = mysqli_query($conn, $result_produtor);
                                    while($row_produtor = mysqli_fetch_assoc($resultado_produtor)){ 
                                ?>
                                <option value="<?php echo $row_produtor['id_func']; ?>"><?php echo $row_produtor['nome_completo_func'];  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>
                          </div>  

                       
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor do Material: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="valor_material" placeholder="Ex: 1500" class="form-control" value=""><small class="form-text text-muted"></small></div>
                          </div>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Encaminhar Para:</label></div>
                            <div class="col-12 col-md-9">
                                <select name="encaminhamento_modelo" class="form-control">
                                    <option value="1">Estúdio</option>
                                    <option value="2">Retorno</option> 
                                    <option value="3">Finalizar Contrato</option>                         
                                </select>
                            </div>       
                          </div>
                      </div>
                      <div class="card-footer">
                        <button type="submit" name="btn_cadastro_agendamento" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Emitir Ordem de Fechamento
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