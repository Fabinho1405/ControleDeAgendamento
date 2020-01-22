<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) && $_SESSION['permissao'] != 1){
    include_once("conection/connection.php");
    $pdo=conectar();
    include_once("php/verificar_sessao.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];


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

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                            <strong class="card-title">Cadastrar</strong> Agendamento Via Instagram <small> Versão Atualizada. </small>
                        </div>
                        <div class="card-body"> 
                        <?php
                        if(isset($_SESSION['errorCad'])){
                            echo "<div class='alert alert-danger' role='alert'>
                            ".$_SESSION['errorCad']." 
                            </div>";
                            unset($_SESSION['errorCadInsta']);
                        };
                        ?>
                            <form action="actions/actCadastrarAgInsta.php" method="POST" name="cadastrarOrdem">
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Nome Completo do Modelo:<b></b></label>
                                </div>
                                <div class="col-12 col-md-7">                  
                                        <input type="text" id="email-input" name="nome_modelo" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" required>
                                </div>
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Idade:<b></b></label>
                                </div>
                                <div class="col-12 col-md-1">                   
                                        <input type="text" id="email-input" name="nascimento_modelo" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" maxlength="2" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Telefone Principal:<b></b></label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                        <input type="text" id="celular" name="telefone_principal" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" minlength="14" required>
                                </div>
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Telefone Secundário:<b></b></label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                        <input type="text" id="celular2" name="telefone_secundario" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" minlength="14">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Nome do(a) Responsável:<b></b></label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                        <input type="text" id="email-input" name="nome_responsavel" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>">
                                </div>
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Email:<b></b></label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                        <input type="text" id="email-input" name="email" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" >
                                </div>
                            </div>

                            <div class="row form-group">

                                <div class="col col-md-2"><label class=" form-control-label">Conta de Captação:<b></b></label></div>
                            <div class="col-12 col-md-4">                               
                              <select name="select_conta_insta" id="select" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                <?php 
                                    $pesquisaProdutor=$pdo->prepare("SELECT id_conta_utilizada, nome_conta_utilizada FROM conta_utilizada WHERE id_func = :idFunc  AND status = '1'");
                                    $pesquisaProdutor->bindValue(":idFunc", $idfuncionario);
                                    $pesquisaProdutor->execute();
                                    $linhaProdutor=$pesquisaProdutor->fetchall(PDO::FETCH_OBJ);
                                    foreach($linhaProdutor as $rowProdutor){

                                ?>
                                <option value="<?php echo $rowProdutor->id_conta_utilizada; ?>"><?php echo $rowProdutor->nome_conta_utilizada;  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>

                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">User: http://www.instagram.com/ </label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                <input type="text" id="email-input" name="instaCli" placeholder="Apenas o nome do usuário.  Não  cole o link completo." class="form-control" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Data Agendada:<b></b></label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                        <input type="date" id="email-input" name="data_agendada" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" required>
                                </div>
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Hora Agendada:<b></b></label>
                                </div>
                                <div class="col-12 col-md-4">                  
                                        <input type="text" id="horario" name="hora_agendada" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" required>
                                </div>
                            </div>


                            

                            
                          <div class="row form-group">
                          <div class="col col-md-12">
                                <center><label for="text-input" class=" form-control-label"><input type="submit" value="Cadastrar Agendamento" class="btn btn-success"></label></center>
                            </div>
                            
                          </div>
                          </form>

                          <div class="row form-group">
                          <div class="col col-md-12">
                               <h3>Informações Adicionais: </h3> <br>
                               <p>
                                    - Respeite sempre as regras de agendamento que foram passadas para você, em relação as padrões de agendamento e o script que deve ser seguido. <br> 
                                    
                                    - É importante que sempre que tiver uma dúvida você entre em contato com o Suporte de nosso sistema, estaremos disponíveis para auxiliar conforme for seu problema. <br>

                                    - Leia com total atenção as exigências da auditoria antes de cadastrar seu agendamento. <br>
                                    

                               </p>
                            </div>
                            
                          </div>


                          


    


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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#horario").mask("00:00");
            $("#celular").mask("(00)00000-0000");
            $("#celular2").mask("(00)00000-0000");
  


            

        });

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