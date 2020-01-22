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
                            <?php
                                $numero_fichas_liberadas = "SELECT * FROM `controle_ligacao` WHERE `id_func` = '9' AND `id_status_sistema` = '1';";
                                $result_numero_fichas_liberadas = mysqli_query($conn, $numero_fichas_liberadas);
                                $qtd_final_fichas_liberadas = mysqli_num_rows($result_numero_fichas_liberadas);
                            ?>
                            <strong class="card-title">Pesquisar </strong> Fichas Ligação 
                        </div>
                        <div class="card-body">
                            <center>
                            <form action="" method="POST">
                                <label> Filtrar Por: </label> &nbsp;
                                <input type="radio" name="filtro" value="1"> Nome &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="filtro" value="2"> Telefone
                                <br>
                                <input type="text" name="parametro" class="form-control">
                                <br>
                                <input type="submit" value="Pesquisar Ficha" class="btn btn-primary" name="enviar">                  
                            </form>
                            <br>
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Modelo</th>
                        <th>Responsável</th>
                        <th>Telefone Principal</th>
                        <th>Telefone Secundário</th>
                        <th>Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                            if(!empty($_POST['enviar'])){
                                $tipo = $_POST['filtro'];
                                $parametro = $_POST['parametro'];
                                if(empty($tipo)){
                                    echo "PREECHA O TIPO";
                                }else if(empty($parametro)){
                                    echo "Preencha o nome";
                                }else if(!empty($tipo) && !empty($parametro)){
                                    if($tipo == 1){
                                        $pesquisa_ficha = "SELECT * FROM controle_ligacao WHERE  id_extracao = '0' AND id_func = '$idfuncionario' AND nome_responsavel_controle LIKE '%$parametro%' OR id_extracao = '0' AND id_func = '$idfuncionario' AND nome_modelo_controle LIKE '%$parametro%'";
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while($row_parametro = mysqli_fetch_assoc($result_parametro)){
                        ?>
                                        <tr>
                        <td><?php  echo $row_parametro['id_controle']; ?></td>
                        <td><?php  echo $row_parametro['nome_modelo_controle']; ?></td>
                        <td><?php  echo $row_parametro['nome_responsavel_controle']; ?></td>
                        <td><?php  echo $row_parametro['telefone_principal_controle']; ?></td>
                        <td><?php  echo $row_parametro['telefone_secundario_controle'];
                            ?></td>                           
                        <td>
                        <?php  
                            $idficha = $row_parametro['id_controle'];
                            $nomemodelo = $row_parametro['nome_modelo_controle'];
                            $responsavel = $row_parametro['nome_responsavel_controle'];
                            $telefoneprincipal = $row_parametro['telefone_principal_controle'];
                            $telefonesecundario = $row_parametro['telefone_secundario_controle'];

                            echo "<a href='cadastrar_agendamento_ligacao.php?idcontrole=$idficha&nomemodelo=$nomemodelo&telefoneprincipal=$telefoneprincipal&telefonesecundario=$telefonesecundario&nomeresponsavel=$responsavel'> Agendar </a>";
                        ?> </td>
                      </tr>
                        <?php
                                        };
                                    }else if($tipo == 2){
                                        $pesquisa_ficha = "SELECT * FROM controle_ligacao WHERE id_extracao = '0' AND id_func = '$idfuncionario' AND telefone_principal_controle LIKE '%$parametro%' OR id_extracao = '0' AND id_func = '$idfuncionario' AND telefone_secundario_controle LIKE '%$parametro%'";
                                        $result_parametro = mysqli_query($conn, $pesquisa_ficha);
                                        while ($row_parametro = mysqli_fetch_assoc($result_parametro)){
                    ?>
                        <tr>
                        <td><?php  echo $row_parametro['id_controle']; ?></td>
                        <td><?php  echo $row_parametro['nome_modelo_controle']; ?></td>
                        <td><?php  echo $row_parametro['nome_responsavel_controle']; ?></td>
                        <td><?php  echo $row_parametro['telefone_principal_controle']; ?></td>
                        <td><?php  echo $row_parametro['telefone_secundario_controle'];
                            ?></td>                           
                        <td>
                        <?php  
                            $idficha = $row_parametro['id_controle'];
                            $nomemodelo = $row_parametro['nome_modelo_controle'];
                            $responsavel = $row_parametro['nome_responsavel_controle'];
                            $telefoneprincipal = $row_parametro['telefone_principal_controle'];
                            $telefonesecundario = $row_parametro['telefone_secundario_controle'];

                            echo "<a href='cadastrar_agendamento_ligacao.php?idcontrole=$idficha&nomemodelo=$nomemodelo&telefoneprincipal=$telefoneprincipal&telefonesecundario=$telefonesecundario&nomeresponsavel=$responsavel'> Agendar </a>";
                        ?> </td>
                      </tr>
                    <?php              
                                        }
                                    }
                                }
                            }else{

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