<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1){
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
                            if(!empty($_GET['cnt'])){
                            $ncontrato = $_GET['cnt'];
                            if($unidadefunc == 4){
                            $pesquisaContrato=$pdo->prepare("SELECT * FROM clientes_concept WHERE contrato_cc=:contrato");
                            $pesquisaContrato->bindValue(":contrato", $ncontrato, PDO::PARAM_INT);

                            }else if($unidadefunc = 1){
                        

                            }

                            $pesquisaContrato->execute();
                            $rowContrato=$pesquisaContrato->fetch(PDO::FETCH_OBJ);

                            }else{

                            }

                        ?> 
                        <strong>Encaminhar</strong> modelo para Cursos
                        
                      </div>
                      <div class="card-body card-block">
                        <form action="exibir_cursos.php?cnt=<?php echo $ncontrato; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">              

                       
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nº de Contrato: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php 
                            if(!empty($rowContrato->contrato_cc)){
                            echo $rowContrato->contrato_cc;
                            }else{
                                echo "<b>Contrato Não Cadastrado em Sistema</b>";
                            } 
                            ?>" disabled="true"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome do Modelo: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php 
                            if(!empty($rowContrato->nome_modelo_cc)){
                            echo $rowContrato->nome_modelo_cc;
                            }else{
                                echo "<b>Contrato Não Cadastrado em Sistema</b>";
                            } 
                            ?>" disabled="true"><small class="form-text text-muted"></small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Idade do Modelo: </label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="" placeholder="" class="form-control" value="<?php 
                            if(!empty($rowContrato->idade_cc)){
                            echo $rowContrato->idade_cc;
                            }else{
                                echo "<b>Contrato Não Cadastrado em Sistema</b>";
                            } 
                            ?>" disabled="true"><small class="form-text text-muted"></small></div>
                          </div>

                           <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Curso:</label></div>
                            <div class="col-12 col-md-9">                              
                              <select name="curso" id="select" class="form-control">
                                <?php 
                                    $selectCursos=$pdo->prepare("SELECT * FROM cursos");
                                    $selectCursos->execute();
                                    $listaCurso=$selectCursos->fetchall(PDO::FETCH_OBJ);
                                    foreach($listaCurso as $rowCursos){ 
                                ?>
                                <option value="<?php echo $rowCursos->id_curso; ?>"><?php echo $rowCursos->descricao_curso;  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>
                          </div> 
                      </div>
                      <div class="card-footer">
                        <button type="submit" name="btn_cadastro_agendamento" class="btn btn-primary btn-sm">
                          <i class="fa fa-dot-circle-o"></i> Verificar Turmas
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