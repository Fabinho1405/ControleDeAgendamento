<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['gerencial']){
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
    <div id="right-panel" class="right-panel">
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
                            $contrato = $_GET['ncontrato'];
                            if($unidadefunc == 1){
                              $select_contrato = "SELECT * FROM clientes_exclusive cc 
                              INNER JOIN funcionario func ON cc.id_produtor = func.id_func
                              WHERE contrato_cc = '$contrato'";
                              $exec_contrato = mysqli_query($conn, $select_contrato);
                              $row_contrato = mysqli_fetch_assoc($exec_contrato);  

                            }else if($unidadefunc == 4){
                              $select_contrato = "SELECT * FROM clientes_concept cc 
                              INNER JOIN funcionario func ON cc.id_produtor = func.id_func
                              WHERE contrato_cc = '$contrato'";
                              $exec_contrato = mysqli_query($conn, $select_contrato);
                              $row_contrato = mysqli_fetch_assoc($exec_contrato);  
                            }
                        ?>                       
                        <strong>Detalhes</strong> do Cliente                       
                      </div>
                      <div class="card-body card-block">
                        <form action="actions/act_modificar_contrato.php?ncontrato=<?php echo $contrato; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Autorizado Por:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $_SESSION['nome_gerencial'];
                              ?>
                            </div>                          
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Contrato:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_contrato['contrato_cc'];
                              ?>
                            </div>                          
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label"><b>Produtor:</b></label></div>
                            <div class="col-12 col-md-9">
                              <?php
                                echo $row_contrato['nome_completo_func'];
                              ?>
                            </div>                           
                          </div>
                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Material:</b><b><font color="red"></font></b></labelcan></div>
                            <div class="col-12 col-md-9">               
                              <select name="select_material" id="select" class="form-control">
                                <option style="background-color: green;color:white;" value="<?php echo $row_contrato['material_cc'] ?>"><?php echo $row_contrato['material_cc']; ?>  -  (Material Selecionado)</option>
                                <?php
                                    if($unidadefunc == 4){
                                ?>
                            
                                    <option value="Agenciamento">Agênciamento</option>
                                    <option value="B1">Book Fotográfico TIPO 1</option>
                                    <option value="B2">Book Fotográfico TIPO 2</option>
                                    <option value="B3">Book Fotográfico TIPO 3</option>
                                    <option value="B4">Book Fotográfico TIPO 4</option>                            
                                
                                <?php
                                    }else if($unidadefunc == 1){
                                ?>
                              
                                    <option value="Agenciamento">Agênciamento</option>
                                    <option value="Basic">Book Fotográfico Basic</option>
                                    <option value="Classic">Book Fotográfico Classic</option>
                                    <option value="Elegance">Book Fotográfico Elegance</option>
                                    <option value="Exclusive">Book Fotográfico Exclusive</option>                            
                               
                                <?php
                                    };
                                ?>
                              </select>                     
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"><b>Valor do Material:</b><b><font color="red"></font></b> </label></div>
                            <div class="col-12 col-md-9">
                              <input type="text" id="text-input" name="valor_material" placeholder="" class="form-control" value="<?php
                                echo $row_contrato['valor_material_cc'];
                              ?>"> 
                            </div>
                          </div>                                                
                         
                        
                          <div class="row form-group">
                            <div class="col col-md-2">
                              <label for="text-input" class=" form-control-label"><b>OFF</b></label>
                            </div>
                            <div class="col col-md-2">
                              <label for="text-input" class=" form-control-label"><b>Status</b></label>
                            </div>
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label"><b>Forma</b></label>
                            </div>
                            <div class="col col-md-2">
                              <label for="text-input" class=" form-control-label"><b>Valor</b></label>
                            </div>
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label"><b>Lançamento</b></label>
                            </div>
                            <?php
                              if($unidadefunc == 1){
                                 $select_lancamento = "SELECT * FROM lancamento_exclusive lc 
                                INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp
                                WHERE lc.n_contrato_lancamento = '$contrato' AND lc.status = '1'";
                                $exec_lancamento = mysqli_query($conn, $select_lancamento);   
                              }else if($unidadefunc == 4){
                                $select_lancamento = "SELECT * FROM lancamento_concept lc 
                                INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp
                                WHERE lc.n_contrato_lancamento = '$contrato' AND lc.status = '1'";
                                $exec_lancamento = mysqli_query($conn, $select_lancamento);                                
                              }
                              while($row_lancamento = mysqli_fetch_assoc($exec_lancamento)){
                            ?>
                            <div class="col-12 col-md-2">
                              <?php 
                              $id_lancamento = $row_lancamento['id_lancamento'];
                              echo 
                              "
                                <input type='checkbox' name='lancamentos_on[]' value='$id_lancamento'>
                              "; ?>
                            </div>
                            <div class="col-12 col-md-2">
                              <?php echo $row_lancamento['descricao_tp']; ?>
                            </div>
                            <div class="col-12 col-md-3">
                              <?php echo $row_lancamento['descricao_tp']; ?>
                            </div>
                            <div class="col-12 col-md-2">
                              <?php echo $row_lancamento['valor_lancamento']; ?>
                            </div>
                            <div class="col-12 col-md-3">
                              <?php echo $row_lancamento['created_lancamento']; ?>
                            </div>
                            <?php
                              };
                            ?>
                           </div>               
                                                        
                      <div class="card-footer">
                        <button type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-magic"></i>&nbsp; Modificar</button>
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
        $ncontrato = $_GET['ncontrato'];
        header("Location: acesso_administrativo.php?ncontrato=$ncontrato");

    }

?>